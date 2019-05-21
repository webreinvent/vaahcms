<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;



use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\ModuleMigration;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\User;


class SetupController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function index()
    {



        return view($this->theme.'.setup.welcome');
    }

    //----------------------------------------------------------
    public function checkSetupStatus()
    {

        //check database connection
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            $response['status'] = 'success';
            $response['data']['active_step'] = 'database';
            return response()->json($response);
        }

        //check users table
        if(!\Schema::hasTable('vh_users'))
        {
            $response['status'] = 'success';
            $response['data']['active_step'] = 'database';
            return response()->json($response);
        }

        $any_admin_exist = User::countAdmins();

        if($any_admin_exist > 0)
        {
            $response['status'] = 'success';
            $response['messages'][] = trans("vaahcms::messages.setup_completed");
            $response['data']['flash_message'] = trans("vaahcms::messages.setup_completed");
            $response['data']['active_step'] = 'completed';
            return response()->json($response);
        }


        $response['status'] = 'success';
        $response['data']['active_step'] = 'database';

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeAppInfo(Request $request)
    {
        $rules = array(
            'app_name' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required'
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $inputs = $request->all();
        $inputs['app_url'] = url("/");

        if(!isset($inputs['db_password']))
        {
            $inputs['db_password'] = "";
        }

        $env_data = \View::make($this->theme.'.setup.partials.setup-env-sample')
            ->with('data', (object)$inputs)->render();

        \File::put(base_path(".env"), $env_data);

        $response['status'] = 'success';
        $response['messages'][] = 'Details Saved';
        $response['data']['env'] = $env_data;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function runMigrations(Request $request)
    {

        $data = [];

        $this->deleteExistingMigration();


        try
        {

            //Set APP_KEY
            $command = 'key:generate';
            $params = [
                '--force' => true
            ];
            \Artisan::call($command, $params);

            //reset migration
            $command = 'migrate:fresh';
            $params = [
                '--force' => true
            ];
            \Artisan::call($command, $params);

            //publish all migrations of vaahcms package
            $command = 'vendor:publish';
            $params = [
                '--provider' => "WebReinvent\VaahCms\VaahCmsServiceProvider",
                '--tag' => "migrations",
                '--force' => true
            ];
            \Artisan::call($command, $params);

            ModuleMigration::syncMigrations();
            //run migration
            $command = 'migrate';
            $params = [
                '--force' => true
            ];
            \Artisan::call($command, $params);

            ModuleMigration::syncMigrations(null, 'vaahcms');

            //publish vaahcms seeds
            $command = 'vendor:publish';
            $params = [
                '--provider' => "WebReinvent\VaahCms\VaahCmsServiceProvider",
                '--tag' => "seeds",
            ];
            \Artisan::call($command, $params);

            //run vaahcms seeds
            $command = 'db:seed';
            $params = [
                '--class' => "VaahCmsTableSeeder"
            ];
            \Artisan::call($command, $params);


            $response['status'] = 'success';
            $response['messages'][] = 'Migration were successful';
            $response['data'] = $data;

            return response()->json($response);

        }
        catch(\Exception $e) {

            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return response()->json($response);
        }


    }

    //----------------------------------------------------------
    public function storeAdmin(Request $request)
    {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'country_calling_code' => 'required',
            'phone' => 'required',
            'username' => 'required',
            'password' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $any_admin_exist = User::countAdmins();

        if($any_admin_exist > 0)
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            return response()->json($response);
        }

        $user = new User();
        $user->fill($request->all());
        $user->uid = uniqid();
        $user->password = \Hash::make($request->password);
        $user->is_active = 1;
        $user->created_ip = \Request::ip();
        $user->save();

        $role = Role::where('slug', 'admin')->first();

        if(!$role)
        {
            $response['status'] = 'failed';
            $response['errors'][] = \Lang::get('vaahcms::messages.not_exist', ['key' => 'role slug', 'value' => 'admin']);;
            return response()->json($response);
        }
        $user->roles()->attach($role->id);

        $response['status'] = 'success';
        $response['messages'][] = trans("vaahcms::messages.setup_completed");
        $response['data']['flash_message'] =  trans("vaahcms::messages.setup_completed");
        $response['data']['active_step'] = 'completed';
        $response['data']['redirect_url'] = \URL::route('vh.admin.login');

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function deleteExistingMigration()
    {

        $path = base_path("database/migrations");

        $migrations = vh_get_all_files($path);

        if(count($migrations) < 1)
        {
            return false;
        }

        foreach ($migrations as $migration)
        {
            $m_path = $path."/".$migration;
            vh_delete_file($m_path);
        }

        return true;
    }
    //----------------------------------------------------------


}
