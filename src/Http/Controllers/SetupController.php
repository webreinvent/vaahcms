<?php

namespace WebReinvent\VaahCms\Http\Controllers;



use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Migration;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\ModuleMigration;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Notifications\TestSmtp;


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


        //check assets exist of not
        if(!file_exists(public_path('vaahcms/backend/vaahone/builds/app.js')))
        {
            //publish assets
            VaahSetup::publishAssets();
        }

        //check .env file exist or not
        if(!file_exists(base_path('.env')))
        {
            //publish assets
            $response = VaahSetup::publishDotEnv();

            if($response['status'] == 'failed')
            {
                abort(403, $response['errors']);
            }

        }

        //check env file has app key
        $list = VaahSetup::getEnvFileVariables('.env');

        if(isset($list['APP_KEY']) || empty(trim($list['APP_KEY'])) || trim($list['APP_KEY']) == "")
        {
            //generate app key
            VaahSetup::generateAppKey();
        }

        return redirect()->route('vh.backend');
    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        $data['is_installed'] = VaahSetup::isInstalled();
        $data['environments'] = vh_environments();
        $data['timezones'] = vh_get_timezones();
        $data['database_types'] = vh_database_types();
        $data['mail_encryption_types'] = vh_mail_encryption_types();
        $data['mail_sample_settings'] = vh_mail_sample_settings();
        $data['country_calling_codes'] = vh_get_countries_calling_codes();
        $data['app_url'] = url("/");

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function appSetupStatus(Request $request)
    {


        $data['is_db_connected'] = VaahSetup::isDBConnected();
        $data['is_db_migrated'] = VaahSetup::isDBMigrated();
        $data['is_admin_created'] = VaahSetup::isInstalled();
        $data['is_user_administrator'] = false;

        $data['stage'] = 'unknown';

        if(VaahSetup::isDBConnected())
        {
            $data['stage'] = 'database';
        }

        if(VaahSetup::isDBMigrated())
        {
            $data['stage'] = 'migrated';
        }

        if(VaahSetup::isAdminCreated())
        {
            $data['stage'] = 'installed';

            if(\Auth::check())
            {
                if(\Auth::user()->hasRole('administrator'))
                {
                    $data['is_user_administrator'] = true;
                }
            }
        }



        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function resetConfirm(Request $request)
    {

        $rules = array(
            'confirm' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        if(!VaahSetup::isInstalled())
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Application is installed.';
            return response()->json($response);
        }

        if(!\Auth::check())
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'You are not logged in.';
            return response()->json($response);
        }

        if(!\Auth::user()->hasRole('administrator'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Permission denied. You must be logged in from Administrator account.';
            return response()->json($response);
        }

        if($request->confirm != 'RESET')
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Type RESET to confirm.';
            return response()->json($response);
        }

        try{

            if($request->delete_media)
            {
                $file = new Filesystem();
                $file->cleanDirectory(base_path('storage/public'));
            }

            if($request->delete_dependencies)
            {
                $file = new Filesystem();
                $file->cleanDirectory(base_path('VaahCms/Modules'));
                $file->cleanDirectory(base_path('VaahCms/Themes'));
            }

            \Auth::logout();

            //remove all database database tables
            \Artisan::call('migrate:reset', ['--force' => true]);

            //clear cache
            VaahHelper::clearCache();
            $request->session()->flush();


            $response['status'] = 'success';
            $response['data'][] = '';

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function testDBConnection(Request $request)
    {

        if(VaahSetup::isInstalled())
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Application is already installed.';
            return response()->json($response);
        }


        $response = VaahSetup::verifyAppUrl($request);

        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }

        $response = VaahHelper::testDBConnection($request);

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function sendTestEmail(Request $request)
    {
        $response = VaahHelper::sendTestEmail($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getConfigurations(Request $request)
    {
        $rules = array(
            'app_env' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $env_file = '.env.'.$request->app_env;

        $file_path = base_path($env_file);

        if(!file_exists($file_path))
        {
            $response['status'] = 'failed';
            $response['errors'] = [];
            return response()->json($response);
        }

        //$params = vh_env_file_to_array($file_path, true);
        $params = VaahSetup::getEnvFileVariables($env_file, 'key_value', true);

        $response['status'] = 'success';
        $response['data'] = $params;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function testConfigurations(Request $request)
    {

        $rules = array(
            'app_env' => 'required',
            'app_name' => 'required',
            'app_timezone' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {
            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        //verify database connection
        if(!$request->has('db_is_valid') || $request->db_is_valid != true)
        {
            $response['status'] = 'failed';
            $response['errors'][] = 'Test the database configuration';
            return response()->json($response);
        }


        //verify mail configuration if set
        /*if($request->has('mail_is_valid') && $request->mail_is_valid == false)
        {
            if($request->has('mail_provider') && !empty($request->mail_provider))
            {
                $response['status'] = 'failed';
                $response['errors'][] = 'Test the mail configuration';
                return response()->json($response);
            }
        }*/


        $response = VaahSetup::verifyAppUrl($request);

        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }


        //generate env file
        $response = VaahSetup::generateEnvFile($request);
        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }

        //generate vaahcms.json file
        $response = VaahSetup::createVaahCmsJsonFile($request);
        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }

        //publish vaahcms configurations
        VaahSetup::publishConfig();


        $data = [];
        $response = [];

        $response['status'] = 'success';
        $response['messages'][] = 'Configuration Saved';
        $response['data'] = $data;
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getRequiredConfigurations()
    {

        $active_env_file = VaahSetup::getActiveEnvFileName();

        $env_params = vh_env_file_to_array(base_path('/'.$active_env_file), true);

        $response['status'] = 'success';
        $response['data']['app_key'] = $env_params['app_key'];
        $response['data']['app_vaahcms_env'] = "";
        if(isset($env_params['app_vaahcms_env']))
        {
            $response['data']['app_vaahcms_env'] = $env_params['app_vaahcms_env'];
        }


        return response()->json($response);
    }
    //----------------------------------------------------------
    public function runMigrations(Request $request)
    {

        $data = [];

        $this->deleteExistingMigration();

        try
        {

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
            $namespace = "WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder";
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
    public function getDependencies(Request $request)
    {
        $response['status'] = 'success';
        $response['data']['list'] = VaahSetup::getDependencies();
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function installDependencies(Request $request)
    {


        $rules = array(
            'name' => 'required',
            'slug' => 'required',
            'type' => 'required',
            'source' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $inputs = $request->all();

        if($request->type=='module')
        {

            if($request->source=='vaahcms')
            {
                $response = $this->downloadOfficialModule($request);
            } else{
                $response = Module::download($request->name, $request->download_link);
            }

            if($response['status'] == 'success')
            {
                Module::syncAllModules();
                Module::activateItem($request->slug);
            }

            if($response['status'] == 'success' && $request->import_sample_data)
            {
                Module::importSampleData($request->slug);
            }


        } else if($request->type=='theme')
        {

            if($request->source=='vaahcms')
            {
                $response = $this->downloadOfficialTheme($request);
            } else{
                $response = Theme::download($request->name, $request->download_link);
            }

            if($response['status'] == 'success')
            {
                Theme::syncAll();
                Theme::activateItem($request->slug);
            }

            if($response['status'] == 'success' && $request->import_sample_data)
            {
                Theme::importSampleData($request->slug);
            }

        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function downloadOfficialModule($request)
    {

        $details = Module::getOfficialDetails($request->slug);

        if($details['status'] == 'failed')
        {
            return $details;

        }

        $response = Module::download($request->name, $details['data']['download_link']);

        return $response;

    }
    //----------------------------------------------------------
    public function downloadOfficialTheme($request)
    {

        $details = Theme::getOfficialDetails($request->slug);

        if($details['status'] == 'failed')
        {
            return $details;

        }

        $response = Theme::download($request->name, $details['data']['download_link']);

        return $response;

    }
    //----------------------------------------------------------
    public function checkSetupStatus()
    {

        //check database connection


        //check users table
        if(!\Schema::hasTable('vh_users'))
        {
            $response['status'] = 'success';
            $response['data']['active_step'] = 'database';
            return response()->json($response);
        }

        $any_admin_exist = User::countAdministrators();

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


    //----------------------------------------------------------
    public function storeAdmin(Request $request)
    {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'country_calling_code' => 'required',
            'phone' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $any_admin_exist = User::countAdministrators();

        if($any_admin_exist > 0)
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            return response()->json($response);
        }

        $user = new User();
        $user->fill($request->all());
        $user->uuid = Str::uuid();
        $user->password = \Hash::make($request->password);
        $user->is_active = 1;
        $user->activated_at = \Carbon::now();
        $user->status = 'active';
        $user->created_ip = \Request::ip();
        $user->save();

        $role = Role::where('slug', 'administrator')->first();

        if(!$role)
        {
            $response['status'] = 'failed';
            $response['errors'][] = \Lang::get('vaahcms::messages.not_exist', ['key' => 'role slug', 'value' => 'administrator']);;
            return response()->json($response);
        }

        Role::syncRolesWithUsers();
        Permission::syncPermissionsWithRoles();

        Permission::recountRelations();
        Role::recountRelations();

        $role->users()->updateExistingPivot($user['id'], array('is_active' => 1));

        $response['status'] = 'success';
        $response['messages'][] = trans("vaahcms::messages.setup_completed");
        $response['data']['flash_message'] =  trans("vaahcms::messages.setup_completed");
        $response['data']['active_step'] = 'completed';
        $response['data']['redirect_url'] = \URL::route('vh.backend');

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
