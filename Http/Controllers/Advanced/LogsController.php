<?php

namespace WebReinvent\VaahCms\Http\Controllers\Advanced;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahLaravel\Libraries\VaahFiles;

class LogsController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $permission_slug = 'has-access-of-logs-section';

        if(!\Auth::user()->hasPermission($permission_slug))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = 'Permission slug: '.$permission_slug;
            }
            return response()->json($response);
        }

        $folder_path = storage_path('logs');

        $files = VaahFiles::getAllFiles($folder_path);
        $list = [];
        $i = 1;

        if(count($files) > 0)
        {
            foreach ($files as $file)
            {
                $list[] = [
                    'id' => $i,
                    'name' => $file,
                    'path' => $folder_path.'\\'.$file,
                ];

                $i++;
            }
        }



        $response['status'] = 'success';
        $response['data']['list'] = $list;

        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-registrations'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $request->merge(['id'=>$id]);
        $response = Registration::getItem($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

        $rules = array(
            'inputs' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = [];

        switch ($action)
        {
            //------------------------------------
            case 'bulk-delete':

                $response = Registration::bulkDelete($request);

                break;
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
