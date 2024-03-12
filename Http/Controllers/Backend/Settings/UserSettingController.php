<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Models\Setting;

class UserSettingController extends Controller
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
            $data['timezones'] = vh_get_timezones();
            $data['country_calling_codes'] = vh_get_countries_calling_codes();
            $data['language_strings'] = [
                "user_settings_heading" => trans("vaahcms-user-setting.user_settings_heading"),
                "fields" => trans("vaahcms-user-setting.fields"),
                "custom_fields" => trans("vaahcms-user-setting.custom_fields"),
                "custom_fields_add_button" => trans("vaahcms-user-setting.custom_fields_add_button"),
                "custom_fields_save_button" => trans("vaahcms-user-setting.custom_fields_save_button"),
                "custom_fields_message" => trans("vaahcms-user-setting.custom_fields_message"),
                "user_setting_expand_all" => trans("vaahcms-user-setting.user_setting_expand_all"),
                "user_setting_collapse_all" => trans("vaahcms-user-setting.user_setting_collapse_all"),
                "apply_to_registration" => trans("vaahcms-user-setting.apply_to_registration"),
                "custom_field_name" => trans("vaahcms-user-setting.custom_field_name"),
                "is_hidden" => trans("vaahcms-user-setting.is_hidden"),
                "no_records" => trans("vaahcms-user-setting.no_records"),
                "field_name" => trans("vaahcms-user-setting.field_name"),
                "select_a_type" => trans("vaahcms-user-setting.select_a_type"),
                "custom_min_length" => trans("vaahcms-user-setting.custom_min_length"),
                "custom_max_length" => trans("vaahcms-user-setting.custom_max_length"),
                "excerpt" => trans("vaahcms-user-setting.excerpt"),
                "custom_is_password_reveal" => trans("vaahcms-user-setting.custom_is_password_reveal"),

            ];
            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $fields = Setting::query()
                ->where('category','user_setting')
                ->where('label','field')
                ->select('id','key','label','type','value')
                ->get();

            $custom_fields = Setting::query()
                ->where('category','user_setting')
                ->where('label','custom_fields')
                ->select('id','key','label','type','value')
                ->first();

            $response['success'] = true;
            $response['data']['list']['fields'] = $fields;
            $response['data']['list']['custom_fields'] = $custom_fields;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

           if (env('APP_DEBUG')) {
               $response['errors'][] = $e->getMessage();
               $response['hint'][] = $e->getTraceAsString();
           } else {
               $response['errors'][] = trans("vaahcms-general.something_went_wrong");
           }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeCustomField(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $inputs = $request->item;

            $rules = array(
                'value.*.name' => 'required',
            );

            $validator = \Validator::make( $inputs, $rules);

            if ($validator->fails()) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $input = $request->item;

            if ($input['id']){
                Setting::query()
                    ->where('id', $input['id'])
                    ->update($input);
            } else {
                $item = new Setting();
                $item->fill($input);
                $item->save();
            }

            $response['success'] = true;
            $response['messages'][] = 'Updated';
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeField(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $input = $request->item;

            Setting::query()->where('id', $input['id'])->update($input);

            $response['success'] = true;
            $response['data']['item'] = $input;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
