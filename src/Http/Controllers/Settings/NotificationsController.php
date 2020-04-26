<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Notification;


class NotificationsController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        $data['notification_variables'] = vh_action('getNotificationVariables', true);
        $data['notification_actions'] = vh_action('getNotificationActions', true);
        $data['notifications'] = Notification::getList($request);
        $data['from'] = env('MAIL_FROM_NAME');
        $data['from_email'] = env('MAIL_FROM_ADDRESS');

        $data['app_url'] = url("/");

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {


        $data = [];

        $list = Notification::getContent($request->id);

        $data['list'] = $list;

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }

    //----------------------------------------------------------

    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        $response = Notification::postStore($request);
        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
