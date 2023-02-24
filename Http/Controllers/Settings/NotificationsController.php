<?php

namespace WebReinvent\VaahCms\Http\Controllers\Settings;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Notification;
use WebReinvent\VaahCms\Entities\Notified;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Notifications\Notice;


class NotificationsController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $data['notification_variables'] = vh_action('getNotificationVariables', null, 'array');
            $data['notification_actions'] = vh_action('getNotificationActions', null, 'array');
            $data['notifications'] = Notification::getList($request);
            $data['from'] = env('MAIL_FROM_NAME');
            $data['from_email'] = env('MAIL_FROM_ADDRESS');
            $data['help_urls'] = [
                'send_notification' => 'https://docs.vaah.dev/vaahcms/basic/setting/notifications.html#sending-without-laravel-queues'
            ];

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
    public function getList(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }


            $data = [];

            $list = Notification::getContent($request->id);

            $data['list'] = $list;

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
    public function createItem(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

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

            $item = new Notification();
            $item->fill($request->all());
            $item->slug = Str::slug($request->name);
            $item->save();


            $response['status'] = 'success';
            $response['messages'][] = 'Saved';
            $response['data']['item'] = $item;
            $response['data']['list'] = Notification::getList($request);

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

    public function store(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

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
    public function send(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $rules = array(
                'notification_id' => 'required',
                'user_id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }


            $response = Notification::send(Notification::find($request->notification_id),
                User::find($request->user_id), $request->all());

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
    public function markAsRead(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-setting-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $rules = array(
                'id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];

            $item = Notified::find($request->id);
            $item->read_at = \Carbon::now();
            $item->marked_delivered = \Carbon::now();
            $item->save();

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
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
