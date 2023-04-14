<?php

namespace WebReinvent\VaahCms\Http\Controllers;



use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\LanguageString;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Notifications\TestSmtp;
use WebReinvent\VaahExtend\Libraries\VaahArtisan;
use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;


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
        \Session::flush();

        //publish assets
        VaahSetup::publishAssets();

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

        try{

            $data['is_installed'] = VaahSetup::isInstalled();
            $data['environments'] = vh_environments();
            $data['timezones'] = vh_get_timezones();
            $data['database_types'] = vh_database_types();
            $data['mail_encryption_types'] = vh_mail_encryption_types();
            $data['mail_sample_settings'] = vh_mail_sample_settings();
            $data['country_calling_codes'] = vh_get_countries_calling_codes();
            $data['env_file'] = env('ENV_FILE');
            $data['app_url'] = url("/");

            $response['status'] = 'success';
            $response['data'] = $data;

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function appSetupStatus(Request $request)
    {

        try{

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

            if(VaahSetup::isSuperAdminCreated())
            {
                $data['stage'] = 'installed';

                if(\Auth::check())
                {
                    if(\Auth::user()->hasRole('super-administrator'))
                    {
                        $data['is_user_administrator'] = true;
                    }
                }
            }



            $response['status'] = 'success';
            $response['data'] = $data;

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

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

        if(!\Auth::user()->hasRole('super-administrator'))
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
            \Schema::disableForeignKeyConstraints();
            \Artisan::call('migrate:fresh', ['--force' => true]);
            \Schema::enableForeignKeyConstraints();

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

        try{

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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function sendTestEmail(Request $request)
    {

        try{

            $response = VaahHelper::sendTestEmail($request);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getConfigurations(Request $request)
    {

        try{

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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function testConfigurations(Request $request)
    {

        try{

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

            $response = VaahSetup::verifyAppUrl($request);

            if($response['status'] == 'failed')
            {
                return response()->json($response);
            }

            $reflector = new \ReflectionClass(\WebReinvent\VaahCms\VaahCmsServiceProvider::class);

            $ref_path = str_replace("VaahCmsServiceProvider.php","",$reflector->getFileName());

            $path =$ref_path .'composer.json';

            $config_data = json_decode(file_get_contents($path), true);

            $request->request->add(['vaahcms_version' => $config_data['version']]);

            //generate env file
            $response = VaahSetup::generateEnvFile($request);
            if($response['status'] == 'failed')
            {
                return response()->json($response);
            }

            //generate vaahcms.json file
            if(!VaahSetup::isAppUrlExistInVaahCmsJson($request))
            {
                $response = VaahSetup::createVaahCmsJsonFile($request);
                if ($response['status'] == 'failed') {
                    return response()->json($response);
                }
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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getRequiredConfigurations()
    {

        try{

            $active_env_file = VaahSetup::getActiveEnvFileName();

            $env_params = vh_env_file_to_array(base_path('/'.$active_env_file), true);

            $response['status'] = 'success';
            $response['data']['app_key'] = $env_params['app_key'];
            $response['data']['app_vaahcms_env'] = "";
            if(isset($env_params['app_vaahcms_env']))
            {
                $response['data']['app_vaahcms_env'] = $env_params['app_vaahcms_env'];
            }

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
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
            $response = VaahArtisan::seed('db:wipe');

            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            //publish all migrations of vaahcms package
            $provider = "WebReinvent\VaahCms\VaahCmsServiceProvider";
            $response = VaahArtisan::publishMigrations($provider);

            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            //run migration
            $response = VaahArtisan::migrate();
            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }


            //publish vaahcms seeds
            $response = VaahArtisan::publishSeeds($provider);
            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }


            //run vaahcms seeds
            $seed_class = "WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder";
            $response = VaahArtisan::seed('db:seed', $seed_class);
            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return $response;
            }

            //publish laravel mail and notifications
            VaahArtisan::publish(null, 'laravel-mail');
            VaahArtisan::publish(null, 'laravel-notifications');

            LanguageString::generateLangFiles();

            $response =[];
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

        try{

            $response['status'] = 'success';
            $response['data']['list'] = VaahSetup::getDependencies();

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function installDependencies(Request $request)
    {

        try{

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
                    Theme::activateItem($request->slug, true);

                }

                if($response['status'] == 'success' && $request->import_sample_data)
                {
                    Theme::importSampleData($request->slug);
                }

            }

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function downloadOfficialModule($request)
    {

        try{

            $details = Module::getOfficialDetails($request->slug);

            if($details['status'] == 'failed')
            {
                return $details;

            }

            $response = Module::download($request->name, $details['data']['download_link']);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;

    }
    //----------------------------------------------------------
    public function downloadOfficialTheme($request)
    {

        try{

            $details = Theme::getOfficialDetails($request->slug);

            if($details['status'] == 'failed')
            {
                return $details;

            }

            $response = Theme::download($request->name, $details['data']['download_link']);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;

    }
    //----------------------------------------------------------
    public function checkSetupStatus()
    {

        try{

            //check users table
            if(!\Schema::hasTable('vh_users'))
            {
                $response['status'] = 'success';
                $response['data']['active_step'] = 'database';
                return response()->json($response);
            }

            $any_super_admin_exist = User::countSuperAdministrators();

            if($any_super_admin_exist > 0)
            {
                $response['status'] = 'success';
                $response['messages'][] = trans("vaahcms::messages.setup_completed");
                $response['data']['flash_message'] = trans("vaahcms::messages.setup_completed");
                $response['data']['active_step'] = 'completed';
                return response()->json($response);
            }


            $response['status'] = 'success';
            $response['data']['active_step'] = 'database';


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    //----------------------------------------------------------


    //----------------------------------------------------------
    public function storeAdmin(Request $request)
    {

        try{
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

            $any_super_admin_exist = User::countSuperAdministrators();

            if($any_super_admin_exist > 0)
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");
                return response()->json($response);
            }

            $user = new User();
            $user->fill($request->all());
            $user->is_active = 1;
            $user->password = $request->password;
            $user->activated_at = \Carbon::now();
            $user->status = 'active';
            $user->created_ip = \Request::ip();
            $user->save();

            $role = Role::where('slug', 'super-administrator')->first();

            if(!$role)
            {
                $response['status'] = 'failed';
                $response['errors'][] = \Lang::get('vaahcms::messages.not_exist', ['key' => 'role slug', 'value' => 'super-administrator']);;
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


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

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
    public function clearCache()
    {

        try{
            VaahArtisan::clearCache();

            $response['status'] = "success";
            return $response;
        }catch(\Exception $e)
        {
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
            return $response;
        }
    }
    //----------------------------------------------------------
    public function publishAssets()
    {

        try{
            //publish assets
            VaahSetup::publishAssets();

            $response['status'] = "success";
            $response['messages'][] = "Assets published.";
            return $response;
        }catch(\Exception $e)
        {
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
            return $response;
        }
    }
    //----------------------------------------------------------

    //----------------------------------------------------------


}
