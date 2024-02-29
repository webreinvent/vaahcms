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
            return vh_get_permission_denied_json_response($permission_slug);
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

            $data['language_strings'] = [
                "notification_heading" => trans("vaahcms-notification-setting.notification_heading"),
                "add_button" => trans("vaahcms-notification-setting.add_button"),
                "placeholder_enter_new_notification_name" => trans("vaahcms-notification-setting.placeholder_enter_new_notification_name"),
                "notification_save_button" => trans("vaahcms-notification-setting.notification_save_button"),
                "column_notification_title" => trans("vaahcms-notification-setting.column_notification_title"),
                "column_edit" => trans("vaahcms-notification-setting.column_edit"),
                "go_back_button" => trans("vaahcms-notification-setting.go_back_button"),
                "notification_options" => trans("vaahcms-notification-setting.notification_options"),
                "variables" => trans("vaahcms-notification-setting.variables"),
                "variables_placeholder_search" => trans("vaahcms-notification-setting.variables_placeholder_search"),
                "error_notifications" => trans("vaahcms-notification-setting.error_notifications"),
                "deliver_via" => trans("vaahcms-notification-setting.deliver_via"),
                "add_subject_button" => trans("vaahcms-notification-setting.add_subject_button"),
                "add_greetings_button" => trans("vaahcms-notification-setting.add_greetings_button"),
                "add_line_button" => trans("vaahcms-notification-setting.add_line_button"),
                "add_action_button" => trans("vaahcms-notification-setting.add_action_button"),
                "notification_test_button" => trans("vaahcms-notification-setting.notification_test_button"),
                "notification_test_send_button" => trans("vaahcms-notification-setting.notification_test_send_button"),
                "placeholder_enter_from" => trans("vaahcms-notification-setting.placeholder_enter_from"),
                "placeholder_content_with_variables" => trans("vaahcms-notification-setting.placeholder_content_with_variables"),
                "placeholder_action_label" => trans("vaahcms-notification-setting.placeholder_action_label"),
                "placeholder_choose_an_action" => trans("vaahcms-notification-setting.placeholder_choose_an_action"),
                "add_content_button" => trans("vaahcms-notification-setting.add_content_button"),
                "add_from_button" => trans("vaahcms-notification-setting.add_from_button"),
                "placeholder_enter_subject" => trans("vaahcms-notification-setting.placeholder_enter_subject"),
                "content_message" => trans("vaahcms-notification-setting.content_message"),
                "notification_field_subject" => trans("vaahcms-notification-setting.notification_field_subject"),
                "notification_field_from_email" => trans("vaahcms-notification-setting.notification_field_from_email"),
                "notification_field_from" => trans("vaahcms-notification-setting.notification_field_from"),
                "notification_field_line" => trans("vaahcms-notification-setting.notification_field_line"),
                "notification_field_greetings" => trans("vaahcms-notification-setting.notification_field_greetings"),
                "notification_field_action" => trans("vaahcms-notification-setting.notification_field_action"),
                "notification_field_message" => trans("vaahcms-notification-setting.notification_field_message"),
                "notification_field_push" => trans("vaahcms-notification-setting.notification_field_push"),
                "frontend" => trans("vaahcms-general-setting.frontend"),
                "backend" => trans("vaahcms-general-setting.backend"),
                "notification_field_mail" => trans("vaahcms-notification-setting.notification_field_mail"),


            ];

            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }

    public function getList(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
            return $response;
        }
    }
    public function getItemData(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }

    public function createItem(Request $request)
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
            return $response;
        }
    }

    public function itemAction(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function listAction(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function send(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function markAsRead(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
