<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Migration;
use WebReinvent\VaahCms\Entities\Module;
use ZanySoft\Zip\Zip;

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
            'slug' => 'required',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = Module::download($request->slug);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        Module::syncAllModules();

        $list = Module::orderBy('created_at', 'DESC');

        if($request->has('q'))
        {
            $list->where(function ($s) use ($request) {
                $s->where('name', 'LIKE', '%'.$request->q.'%')
                    ->where('title', 'LIKE', '%'.$request->q.'%');
            });
        }

        if($request->has('status') && $request->get('status') != 'all')
        {
            switch ($request->status)
            {
                case 'active':
                    $list->active();
                    break;
                case 'inactive':
                    $list->inactive();
                    break;
                case 'update_available':
                    $list->updateavailable();
                    break;
            }
        }

        $stats['all'] = Module::count();
        $stats['active'] = Module::active()->count();
        $stats['inactive'] = Module::inactive()->count();
        $stats['update_available'] = Module::updateAvailable()->count();


        $response['status'] = 'success';
        $response['data']['list'] = $list->paginate(10);
        $response['data']['stats'] = $stats;

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


        //check dependencies are installed and active
        if(isset($response['status'])
            && $response['status'] == 'success'
            && isset($response['dependencies'])
            && is_array($response['dependencies'])
        )
        {

            $response = Module::validateDependencies($response['dependencies']);

            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return response()->json($response);
            }

        }


        switch($request->action)
        {

            //---------------------------------------
            case 'activate':
                Module::activate($module->slug);
                break;
            //---------------------------------------
            case 'deactivate':
                $this->deactivate($module);
                $module->is_active = null;
                $module->save();
                break;
            //---------------------------------------
            case 'importSampleData':
                Module::importSampleData($module->slug);
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

        //Delete module settings too
        $module->settings()->delete();

        //Delete module entry
        Module::where('slug', $module->slug)->forceDelete();


        $module_path = base_path() . "/vaahcms/Modules/".$module->name;

        //Delete all migrations
        $path =  $module_path . "/Database/migrations/";

        $migrations = vh_get_all_files($path);

        if(count($migrations) > 0)
        {
            foreach($migrations as $migration)
            {
                $migration_path = $path.$migration;
                include_once ($migration_path);
                $migration_class = vh_get_class_from_file($migration_path);

                if($migration_class)
                {
                    $migration_obj = new $migration_class;
                    $migration_obj->down();
                }
            }
        }

        //delete all database migrations
        $module_migrations = $module->migrations()->get()->pluck('migration_id')->toArray();

        if($module_migrations)
        {
            \DB::table('migrations')->whereIn('id', $module_migrations)->delete();
            Migration::whereIn('migration_id', $module_migrations)->delete();
        }

        //delete module folder
        vh_delete_folder($module_path);

    }
    //----------------------------------------------------------
    public function getModulesSlugs(Request $request)
    {

        $module_slugs = Module::all()->pluck('slug')->toArray();

        $module_slugs = implode($module_slugs,",");

        $response['status'] = 'success';
        $response['data'] = $module_slugs;
        return response()->json($response);

    }

    //----------------------------------------------------------
    public function updateModuleVersions(Request $request)
    {
        if(!$request->has('modules'))
        {
            $response['status'] = 'success';
            return response()->json($response);
        }

        foreach($request->get('modules') as $module)
        {
            $installed_module = Module::where('slug', $module['slug'])->first();

            if($installed_module->version_number < $module['version_number'])
            {
                $installed_module->is_update_available = 1;
                $installed_module->update_checked_at = Carbon::now();
                $installed_module->save();
            }

        }

        $response['status'] = 'success';
        return response()->json($response);

    }

    //----------------------------------------------------------
    public function installUpdates(Request $request)
    {
        $rules = array(
            'slug' => 'required',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $module = Module::where('slug', $request->slug)->first();

        if(!$module)
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.not_exist", ['key' => 'slug', 'value' => $request->slug]);
            return response()->json($response);

        }


        $parsed = parse_url($module->github_url);


        $uri_parts = explode('/', $parsed['path']);
        $folder_name = end($uri_parts);
        $folder_name = $folder_name."-master";


        $filename = $module->name.'.zip';
        $folder_path = base_path()."/vaahcms/Modules/";
        $path = $folder_path.$filename;

        copy($module->github_url.'/archive/master.zip', $path);

        try{
            Zip::check($path);
            $zip = Zip::open($path);
            $zip->extract(base_path().'/vaahcms/Modules/');
            $zip->close();

            rename($folder_path."".$folder_name, $folder_path.$module->name);

            vh_delete_folder($path);

            $response['status'] = 'success';
            $response['messages'][] = 'Module Updated';
            return response()->json($response);

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
            return response()->json($response);
        }


    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
