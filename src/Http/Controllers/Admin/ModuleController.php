<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Module;
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

        switch($request->action)
        {

            //---------------------------------------
            case 'activate':

                //run migration
                $command = 'migrate';
                $params = [
                    '--path' => "./vaahcms/Modules/".$module->name."/Database/Migrations",
                    '--force' => true
                ];

                echo "<pre>";
                print_r($params);
                echo "</pre>";

                \Artisan::call($command, $params);

                //Run seeds

                \Artisan::call('db:seed', [
                    '--class' => "\VaahCms\Modules\\{$module->name}\\Database\Seeders"
                ]);

                //run migration
                //run seeds

                //method to be called
                $method = "activate";

                break;
            //---------------------------------------
            case 'deactivate':





                break;
            //---------------------------------------

            case 'delete':

                //run migration
                $command = 'migrate:refresh';
                $params = [
                    '--path' => "./vaahcms/Modules/".$module->name."/Database/Migrations",
                    '--force' => true
                ];

                \Artisan::call($command, $params);

                echo "<pre>";
                print_r($params);
                echo "</pre>";

                break;
            //---------------------------------------
            //---------------------------------------
            //---------------------------------------
            //---------------------------------------
        }


        $response = null;

        try{

            if (isset($method) && method_exists($controller, $method)
                && is_callable(array($controller, $method)))
            {
                $response = call_user_func($controller."::".$method, $module);
                $response['data']['controller_method'] = $controller;
            }

        }catch(\Exception $e)
        {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
