<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\Notification;
use WebReinvent\VaahCms\Models\Notified;
use WebReinvent\VaahCms\Models\User;

class NotificationsController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $data['notification_variables'] = vh_action('getNotificationVariables', null, 'array');
            $data['notification_actions'] = vh_action('getNotificationActions', null, 'array');
            $data['from'] = env('MAIL_FROM_NAME');
            $data['from_email'] = env('MAIL_FROM_ADDRESS');
            $data['help_urls'] = [
                'send_notification' => 'https://docs.vaah.dev/vaahcms/basic/setting/notifications.html#sending-without-laravel-queues'
            ];

            $data['app_url'] = url("/");

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    public function getList(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try{
            return Notification::getList($request);
        }catch (\Exception $e){
            $response = [];
            $response['success'] = false;
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
            return $response;
        }
    }
    public function getItemData(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $data = [];

            $list = Notification::getContent($request->id);

            $data['list'] = $list;

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }

    public function createItem(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try{
            return Notification::createItem($request);
        }catch (\Exception $e){
            $response = [];
            $response['success'] = false;
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
            return $response;
        }
    }

    public function itemAction(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Notification::itemAction($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function listAction(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Notification::listAction($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $rules = array(
                'name' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];

            $response = Notification::postStore($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function send(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $rules = array(
                'notification_id' => 'required',
                'user_id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {
                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];
            $response = [];

            $response = Notification::dispatch(Notification::find($request->notification_id),
                User::query()->find($request->user_id), $request->all());
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function markAsRead(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $rules = array(
                'id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];

            $item = Notified::find($request->id);
            $item->read_at = \Carbon::now();
            $item->marked_delivered = \Carbon::now();
            $item->save();

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
