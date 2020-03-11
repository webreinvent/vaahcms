<?php

namespace WebReinvent\VaahCms\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Migration;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\ModuleMigration;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;


class SetupController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
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

        $inputs['app_env'] = env('APP_ENV');

        $env_data = \View::make($this->theme.'.setup.partials.setup-env-sample')
            ->with('data', (object)$inputs)->render();

        if(app()->environment() == 'local')
        {
            $env_file = ".env";
        } else
        {
            $env_file = ".env.".app()->environment();
        }

        \File::put(base_path($env_file), $env_data);

        $response['status'] = 'success';
        $response['messages'][] = 'Details Saved';
        $response['data']['env'] = $env_data;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function runMigrations(Request $request)
    {

        $data = [];

        //$this->deleteExistingMigration();

        try
        {

            //Set APP_KEY
            $command = 'key:generate';
            $params = [
                '--force' => true
            ];
            \Artisan::call($command, $params);

            //reset migration
            Migration::resetMigrations();

            //publish all migrations of vaahcms package
            $provider = "WebReinvent\VaahCms\VaahCmsServiceProvider";
            Migration::publishMigrations($provider);

            //run migration
            Migration::runMigrations(null,true);

            //publish vaahcms seeds
            Migration::publishSeeds($provider);

            //run vaahcms seeds
            $namespace = "VaahCmsTableSeeder";
            Migration::runSeeds($namespace);

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

    public function setupCMS(Request $request)
    {

        $inputs = $request->all();

        //download cms module
        $default_module_slug = 'cms';
        $response = Module::download($default_module_slug);
        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }
        Module::syncAllModules();
        Module::activate($default_module_slug);

        if(isset($inputs[$default_module_slug]['sample_data']) && $inputs[$default_module_slug]['sample_data'] == true)
        {
            Module::importSampleData($default_module_slug);
        }

        //download theme
        $default_theme_slug = 'btfourpointthree';
        $response = Theme::download($default_theme_slug);
        if($response['status'] == 'failed' )
        {
            return response()->json($response);
        }
        Theme::syncAll();
        Theme::activate($default_theme_slug);
        if(isset($inputs['theme']['sample_data']) && $inputs['theme']['sample_data'] == true)
        {
            Theme::importSampleData($default_theme_slug);
        }

        $data = [];

        $response['status'] = 'success';
        $response['messages'][] = 'CMS setup was successful';

        return response()->json($response);

    }

    //----------------------------------------------------------

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
        $user->status = 'active';
        $user->created_ip = \Request::ip();
        $user->save();

        $role = Role::where('slug', 'admin')->first();

        if(!$role)
        {
            $response['status'] = 'failed';
            $response['errors'][] = \Lang::get('vaahcms::messages.not_exist', ['key' => 'role slug', 'value' => 'admin']);;
            return response()->json($response);
        }

        Role::syncRolesWithUsers();
        Permission::syncPermissionsWithRoles();

        Permission::recountRelations();
        Role::recountRelations();

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
