<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Theme;

class ThemesController extends Controller
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

        if(!\Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        Theme::syncAll();

        $data['vaahcms_api_route'] = config('vaahcms.api_route');
        $data['debug'] = config('vaahcms.debug');
        $data['installed'] = Theme::select('slug')->get()->pluck('slug')->toArray();

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        Theme::syncAll();

        $list = Theme::orderBy('created_at', 'DESC');

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

        $stats['all'] = Theme::count();
        $stats['active'] = Theme::active()->count();
        $stats['inactive'] = Theme::inactive()->count();
        $stats['update_available'] = Theme::updateAvailable()->count();


        $response['status'] = 'success';
        $response['data']['list'] = $list->paginate(config('vaahcms.per_page'));
        $response['data']['stats'] = $stats;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-theme'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Theme::getItem($id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function download(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-install-theme'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

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

        $response = Theme::download($request->name, $request->download_link);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function installUpdates(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-update-theme'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

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

        $response = Theme::installUpdates($request);

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
        $theme = Theme::find($inputs['id']);

        $method_name = str_replace("_", " ", $request->action);
        $method_name = ucwords($method_name);
        $method_name = lcfirst(str_replace(" ", "", $method_name));

        $response = vh_theme_action($theme->name, 'SetupController@'.$method_name);
        if($response['status'] == 'failed')
        {
            return response()->json($response);
        }

        switch($request->action)
        {

            //---------------------------------------
            case 'activate':
                if(!\Auth::user()->hasPermission('can-activate-theme'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return response()->json($response);
                }
                $response = Theme::activateItem($theme->slug);
                break;
            //---------------------------------------
            case 'make_default':
                if(!\Auth::user()->hasPermission('can-activate-theme'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return response()->json($response);
                }
                $response = Theme::makeItemAsDefault($theme->slug);
                break;
            //---------------------------------------
            case 'deactivate':
                if(!\Auth::user()->hasPermission('can-deactivate-theme'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return response()->json($response);
                }
                $response = Theme::deactivateItem($theme->slug);
                break;
            //---------------------------------------

            //---------------------------------------
            case 'import_sample_data':
                if(!\Auth::user()->hasPermission('can-import-sample-data-in-theme'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return response()->json($response);
                }
                $response = Theme::importSampleData($theme->slug);
                break;
            //---------------------------------------
            case 'delete':
                if(!\Auth::user()->hasPermission('can-delete-theme'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return response()->json($response);
                }
                $response = Theme::deleteItem($theme->slug);
                break;
            //---------------------------------------
            //---------------------------------------

        }

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function storeUpdates(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-update-theme'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'themes' => 'required|array',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = Theme::storeUpdates($request);

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
