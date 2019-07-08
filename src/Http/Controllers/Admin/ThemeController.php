<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Migration;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Theme;
use ZanySoft\Zip\Zip;

class ThemeController extends Controller
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
        return view($this->theme.'.pages.themes');
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

        $response = Theme::download($request->slug);

        return response()->json($response);


    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        Theme::syncAll();

        $list = Theme::orderBy('is_active', 'DESC');

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

        $theme = Theme::find($inputs['id']);

        $controller = "\VaahCms\Themes\\{$theme->name}\\Http\Controllers\SetupController";
        $method = $request->action;

        $response = $this->callControllerMethod($theme, $controller, $method);

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

            $response = Theme::validateDependencies($response['dependencies']);

            if(isset($response['status']) && $response['status'] == 'failed')
            {
                return response()->json($response);
            }

        }



        switch($request->action)
        {

            //---------------------------------------
            case 'activate':
                Theme::activate($theme->slug);
                break;
            //---------------------------------------
            case 'deactivate':
                $this->deactivate($theme);
                $theme->is_active = null;
                $theme->save();
                break;
            //---------------------------------------
            case 'importSampleData':
                $this->importSampleData($theme);
                $response['status'] = 'success';
                $response['messages'][] = 'Sample Data Successfully Imported';
                return response()->json($response);
                break;
            //---------------------------------------
            case 'delete':

                $this->delete($theme);

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
    public function importSampleData($theme)
    {

        Theme::importSampleData($theme->slug);

    }
    //----------------------------------------------------------
    public function deactivate($module)
    {

    }
    //----------------------------------------------------------
    public function callControllerMethod($theme, $controller, $method)
    {

        if (isset($method) && method_exists($controller, $method)
            && is_callable(array($controller, $method)))
        {
            $response = call_user_func($controller."::".$method, $theme);
            $response['data']['controller_method'] = $controller;

            return $response;
        }

    }
    //----------------------------------------------------------
    public function delete($theme)
    {

        //Delete module settings too
        $theme->settings()->delete();

        //Delete module entry
        Theme::where('slug', $theme->slug)->forceDelete();


        $theme_path = base_path() . "/vaahcms/Themes/".$theme->name;

        //Delete all migrations
        $path =  $theme_path . "/Database/migrations/";

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
        $module_migrations = $theme->migrations()->get()->pluck('migration_id')->toArray();

        if($module_migrations)
        {
            \DB::table('migrations')->whereIn('id', $module_migrations)->delete();
            Migration::whereIn('migration_id', $module_migrations)->delete();
        }

        //delete module folder
        vh_delete_folder($theme_path);

    }
    //----------------------------------------------------------
    public function getThemeSlugs(Request $request)
    {

        $slugs = Theme::all()->pluck('slug')->toArray();

        $slugs = implode($slugs,",");

        $response['status'] = 'success';
        $response['data'] = $slugs;
        return response()->json($response);

    }

    //----------------------------------------------------------
    public function updateModuleVersions(Request $request)
    {
        if(!$request->has('themes'))
        {
            $response['status'] = 'success';
            return response()->json($response);
        }

        foreach($request->get('themes') as $theme)
        {
            $installed = Theme::where('slug', $theme['slug'])->first();

            if($installed->version_number < $theme['version_number'])
            {
                $installed->is_update_available = 1;
                $installed->update_checked_at = Carbon::now();
                $installed->save();
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

        $theme = Theme::where('slug', $request->slug)->first();

        if(!$theme)
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.not_exist", ['key' => 'slug', 'value' => $request->slug]);
            return response()->json($response);

        }


        $parsed = parse_url($theme->github_url);

        $uri_parts = explode('/', $parsed['path']);
        $folder_name = end($uri_parts);
        $folder_name = $folder_name."-master";


        $filename = $theme->name.'.zip';
        $folder_path = base_path()."/vaahcms/Themes/";
        $path = $folder_path.$filename;

        copy($theme->github_url.'/archive/master.zip', $path);

        try{
            Zip::check($path);
            $zip = Zip::open($path);
            $zip->extract(base_path().'/vaahcms/Themes/');
            $zip->close();

            rename($folder_path."".$folder_name, $folder_path.$theme->name);

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
