<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Migration;
use WebReinvent\VaahCms\Entities\Module;
use ZanySoft\Zip\Zip;

class ModulesController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------

    //----------------------------------------------------------
    public function assets(Request $request)
    {
        Module::syncAllModules();

        $data['vaahcms_api_route'] = config('vaahcms.api_route');
        $data['debug'] = config('vaahcms.debug');
        $data['installed'] = Module::select('slug')->get()->pluck('slug')->toArray();

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public function getList(Request $request)
    {

        Module::syncAllModules();

        $list = Module::orderBy('created_at', 'DESC');

        if($request->has('q'))
        {
            $list->where(function ($s) use ($request) {
                $s->where('name', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('slug', 'LIKE', '%'.$request->q.'%')
                    ->orWhere('title', 'LIKE', '%'.$request->q.'%');
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
        $response['data']['list'] = $list->paginate(config('vaahcms.per_page'));
        $response['data']['stats'] = $stats;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        $response = Module::getDetail($id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function download(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'download_link' => 'required',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = Module::download($request->name, $request->download_link);

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


        /*
         * Call method from module setup controller
         */
        $module = Module::find($inputs['id']);

        $method_name = str_replace("_", " ", $request->action);
        $method_name = ucwords($method_name);
        $method_name = lcfirst(str_replace(" ", "", $method_name));

        $response = vh_module_action($module->name, 'SetupController@'.$method_name);
        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }


        switch($request->action)
        {

            //---------------------------------------
            case 'activate':
                $response = Module::activateItem($module->slug);
                break;
            //---------------------------------------
            case 'deactivate':
                $response = Module::deactivateItem($module->slug);
                break;
            //---------------------------------------
            case 'import_sample_data':
                $response = Module::importSampleData($module->slug);
                break;
            //---------------------------------------
            case 'delete':
                $response = Module::deleteItem($module->slug);
                break;
            //---------------------------------------
            //---------------------------------------

        }

        return response()->json($response);
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
    public function storeUpdates(Request $request)
    {
        $rules = array(
            'modules' => 'required|array',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = Module::storeUpdates($request);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function installUpdates(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'download_link' => 'required',
        );

        $validator = \Validator::make( $request->toArray(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = Module::installUpdates($request);

        return response()->json($response);


    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
