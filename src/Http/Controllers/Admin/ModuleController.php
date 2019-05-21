<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\ModuleMigration;
use WebReinvent\VaahCms\Entities\User;
use ZanySoft\Zip\Zip;
use ZanySoft\Zip\ZipManager;

class ModuleController extends Controller
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
        return view($this->theme.'.pages.modules');
    }
    //----------------------------------------------------------
    public function assets(Request $request)
    {
        $data['vaahcms_api_route'] = config('vaahcms.api_route');
        $data['debug'] = config('vaahcms.debug');

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function download(Request $request)
    {

        $rules = array(
            'github_url' => 'required',
            'name' => 'required',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }


        $parsed = parse_url($request->github_url);


        $uri_parts = explode('/', $parsed['path']);
        $folder_name = end($uri_parts);
        $folder_name = $folder_name."-master";


        $filename = $request->name.'.zip';
        $folder_path = base_path()."/vaahcms/Modules/";
        $path = $folder_path.$filename;

        copy($request->github_url.'/archive/master.zip', $path);

        try{
            Zip::check($path);
            $zip = Zip::open($path);
            $zip->extract(base_path().'/vaahcms/Modules/');

            rename($folder_path."".$folder_name, $folder_path.$request->name);

            //TODO:: Delete zip file

            $response['status'] = 'success';
            $response['messages'][] = 'installed';
            return response()->json($response);

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return response()->json($response);
        }


    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        Module::syncAllModules();

        $list = Module::with(['settings'])
            ->orderBy('created_at', 'DESC');

        if($request->has('q'))
        {
            $list->where(function ($s) use ($request) {
                $s->where('name', 'LIKE', '%'.$request->q.'%')
                    ->where('title', 'LIKE', '%'.$request->q.'%');
            });
        }

        $response['status'] = 'success';
        $response['data']['list'] = $list->paginate(10);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function actions(Request $request)
    {
        $rules = array(
            'action' => 'required',
            'inputs' => 'required',
            'inputs.id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];
        $inputs = $request->inputs;

        $module = Module::find($inputs['id']);

        $controller = "\VaahCms\Modules\\{$module->name}\\Http\Controllers\SetupController";
        $method = $request->action;

        $response = $this->callModuleControllerMethod($module, $controller, $method);

        if(isset($response['status']) && $response['status'] == 'failed')
        {
            return response()->json($response);
        }

        switch($request->action)
        {

            //---------------------------------------
            case 'activate':
                $this->activate($module);
                $module->is_active = 1;
                $module->save();
                break;
            //---------------------------------------
            case 'deactivate':
                $this->deactivate($module);
                $module->is_active = null;
                $module->save();
                break;
            //---------------------------------------
            case 'importSampleData':
                $this->importSampleData($module);
                $response['status'] = 'success';
                $response['messages'][] = 'Sample Data Successfully Imported';
                return response()->json($response);
                break;
            //---------------------------------------
            case 'delete':

                $this->delete($module);

                break;
            //---------------------------------------
            //---------------------------------------
            //---------------------------------------
            //---------------------------------------
        }

        $response['status'] = 'success';
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function activate($module)
    {

        $path = "./vaahcms/Modules/".$module->name."/Database/migrations/";
        $path_des = "./database/migrations";

        //\copy($path, $path_des);

        \File::copyDirectory($path, $path_des);

        ModuleMigration::syncMigrations();
        //run migration
        $command = 'migrate';
        \Artisan::call($command);
        ModuleMigration::syncMigrations($module->id, $module->slug);

        $command = 'db:seed';
        $params = [
            '--class' => "VaahCms\Modules\\{$module->name}\\Database\Seeds\DatabaseTableSeeder"
        ];

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    public function importSampleData($module)
    {

        $command = 'db:seed';
        $params = [
            '--class' => "VaahCms\Modules\\{$module->name}\\Database\Seeds\SampleDataTableSeeder"
        ];

        \Artisan::call($command, $params);

    }
    //----------------------------------------------------------
    public function deactivate($module)
    {

    }
    //----------------------------------------------------------
    public function callModuleControllerMethod($module, $controller, $method)
    {

        if (isset($method) && method_exists($controller, $method)
            && is_callable(array($controller, $method)))
        {
            $response = call_user_func($controller."::".$method, $module);
            $response['data']['controller_method'] = $controller;

            return $response;
        }

    }
    //----------------------------------------------------------
    public function delete($module)
    {

        //Delete module entry
        Module::where('slug', $module->slug)->forceDelete();

        //Delete all migrations
        $path =  base_path() . "/vaahcms/Modules/Blog/Database/migrations/";

        $migrations = vh_get_all_files($path);

        if(count($migrations) > 0)
        {
            foreach($migrations as $migration)
            {
                $migration_path = $path.$migration;
                include_once ($migration_path);
                $migration_class = $this->get_class_from_file($migration_path);

                if($migration_class)
                {
                    $migration_obj = new $migration_class;
                    $migration_obj->down();
                }
            }
        }

        //delete all database migrations
        $module_migrations = ModuleMigration::where('module_slug', $module->slug)
            ->groupBy('batch')
            ->orderBy('batch', 'DESC')
            ->get()->pluck('migration_id')->toArray();

        if($module_migrations)
        {
            \DB::table('migrations')->whereIn('id', $module_migrations)->delete();
            ModuleMigration::whereIn('migration_id', $module_migrations)->delete();
        }

        //\Artisan::call($command, $params);


        //delete module folder

    }
    //----------------------------------------------------------
    public function get_class_from_file($path_to_file)
    {
        //Grab the contents of the file
        $contents = file_get_contents($path_to_file);

        //Start with a blank namespace and class
        $namespace = $class = "";

        //Set helper values to know that we have found the namespace/class token and need to collect the string values after them
        $getting_namespace = $getting_class = false;

        //Go through each token and evaluate it as necessary
        foreach (token_get_all($contents) as $token) {

            //If this token is the namespace declaring, then flag that the next tokens will be the namespace name
            if (is_array($token) && $token[0] == T_NAMESPACE) {
                $getting_namespace = true;
            }

            //If this token is the class declaring, then flag that the next tokens will be the class name
            if (is_array($token) && $token[0] == T_CLASS) {
                $getting_class = true;
            }

            //While we're grabbing the namespace name...
            if ($getting_namespace === true) {

                //If the token is a string or the namespace separator...
                if(is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {

                    //Append the token's value to the name of the namespace
                    $namespace .= $token[1];

                }
                else if ($token === ';') {

                    //If the token is the semicolon, then we're done with the namespace declaration
                    $getting_namespace = false;

                }
            }

            //While we're grabbing the class name...
            if ($getting_class === true) {

                //If the token is a string, it's the name of the class
                if(is_array($token) && $token[0] == T_STRING) {

                    //Store the token's value as the class name
                    $class = $token[1];

                    //Got what we need, stope here
                    break;
                }
            }
        }

        //Build the fully-qualified class name and return it
        return $namespace ? $namespace . '\\' . $class : $class;

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
