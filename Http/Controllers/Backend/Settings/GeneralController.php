<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Models\Language;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Libraries\VaahHelper;

class GeneralController extends Controller
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
            $role_data = [];
            foreach (Role::getActiveRoles() as $key => $value){
                $role_data[$key] = $value->name;
            }

            $vh_file_types_data = [];
            foreach (vh_file_types() as $key => $value){
                $vh_file_types_data[$key] = $value['name'];
            }

            $response['success'] = true;
            $response['data']['base_url'] = url('/');
            $response['data']['roles'] = $role_data;
            $response['data']['language_strings'] = $this->getLanguageStrings();
            $response['data']['file_types'] = $vh_file_types_data;
            $response['data']['vh_meta_attributes'] = vh_meta_attributes();
            $response['data']['languages'] = Language::select('name', 'locale_code_iso_639')->get();
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
    public function getLanguageStrings() : array {

        return  [
            "general_settings_title" => trans("vaahcms-general-setting.heading"),
            "expand_all" => trans("vaahcms-general-setting.expand_all"),
            "collapse_all" => trans("vaahcms-general-setting.collapse_all"),
            "site_settings" => trans("vaahcms-general-setting.site_settings"),
            "site_settings_message" => trans("vaahcms-general-setting.site_settings_message"),
            "securities" => trans("vaahcms-general-setting.securities"),
            "securities_message" => trans("vaahcms-general-setting.securities_message"),
            "date_and_time" => trans("vaahcms-general-setting.date_and_time"),
            "global_date_and_time_settings" => trans("vaahcms-general-setting.global_date_and_time_settings"),
            "social_media_and_links" => trans("vaahcms-general-setting.social_media_and_links"),
            "static_links_management" => trans("vaahcms-general-setting.static_links_management"),
            "scripts" => trans("vaahcms-general-setting.scripts"),
            "scripts_message" => trans("vaahcms-general-setting.scripts_message"),
            "meta_tags" => trans("vaahcms-general-setting.meta_tags"),
            "global_meta_tags" => trans("vaahcms-general-setting.global_meta_tags"),
            "site_title" => trans("vaahcms-general-setting.site_title"),
            "default_site_language" => trans("vaahcms-general-setting.default_site_language"),
            "redirect_after_frontend_login" => trans("vaahcms-general-setting.redirect_after_frontend_login"),
            "meta_description" => trans("vaahcms-general-setting.meta_description"),
            "search_engine_visibility" => trans("vaahcms-general-setting.search_engine_visibility"),
            "assign_roles_on_registration" => trans("vaahcms-general-setting.assign_roles_on_registration"),
            "allowed_file_types_for_upload" => trans("vaahcms-general-setting.allowed_file_types_for_upload"),
            "is_logo_compressed_with_sidebar" => trans("vaahcms-general-setting.is_logo_compressed_with_sidebar"),
            "copyright_text" => trans("vaahcms-general-setting.copyright_text"),
            "copyright_year" => trans("vaahcms-general-setting.copyright_year"),
            "maximum_number_of_login_attempts" => trans("vaahcms-general-setting.maximum_number_of_login_attempts"),
            "password_protection" => trans("vaahcms-general-setting.password_protection"),
            "laravel_queues" => trans("vaahcms-general-setting.laravel_queues"),
            "maintenance_mode" => trans("vaahcms-general-setting.maintenance_mode"),
            "signup_page" => trans("vaahcms-general-setting.signup_page"),
            "redirect_after_backend_logout" => trans("vaahcms-general-setting.redirect_after_backend_logout"),
            "save_settings_button" => trans("vaahcms-general-setting.save_settings_button"),
            "clear_cache_button" => trans("vaahcms-general-setting.clear_cache_button"),
            "allowed_file_size_for_upload" => trans("vaahcms-general-setting.allowed_file_size_for_upload"),
            "copyright_link" => trans("vaahcms-general-setting.copyright_link"),
            "max_number_of_forgot_password_attempts" => trans("vaahcms-general-setting.max_number_of_forgot_password_attempts"),
            "backend_home_page_link" => trans("vaahcms-general-setting.backend_home_page_link"),
            "localization_placeholder_select_a_language" => trans("vaahcms-localization-setting.localization_placeholder_select_a_language"),
            "enter_custom_text" => trans("vaahcms-general-setting.enter_custom_text"),
            "enter_custom_link" => trans("vaahcms-general-setting.enter_custom_link"),
            "enter_redirection_link" => trans("vaahcms-general-setting.enter_redirection_link"),
            "enable" => trans("vaahcms-general-setting.enable"),
            "disable" => trans("vaahcms-general-setting.disable"),
            "true" => trans("vaahcms-general-setting.true"),
            "false" => trans("vaahcms-general-setting.false"),
            "use_app_name" => trans("vaahcms-general-setting.use_app_name"),
            "use_app_url" => trans("vaahcms-general-setting.use_app_url"),
            "use_current_year" => trans("vaahcms-general-setting.use_current_year"),
            "backend" => trans("vaahcms-general-setting.backend"),
            "frontend" => trans("vaahcms-general-setting.frontend"),
            "custom" => trans("vaahcms-general-setting.custom"),
        ];
    }
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $data = [];

            $data['list'] = Setting::getGlobalSettings($request);
            $data['links'] = Setting::getGlobalLinks($request);
            $data['scripts'] = Setting::getGlobalScripts($request);
            $data['meta_tags'] = Setting::getGlobalMetaTags($request);
            $data['is_smtp_configured'] = config('mail.mailers.smtp.username') &&
                config('mail.mailers.smtp.password');

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
   // ----------------------------------------------------------
    public function storeSiteSettings(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            foreach ($request->list as $key => $value){
                $setting = Setting::query()
                    ->where('category', 'global')
                    ->where('key', $key)
                    ->first();

                if (!$setting) {
                    $setting = new Setting();
                    $setting->key = $key;
                    $setting->value = $value;
                    $setting->category = 'global';
                    $setting->save();
                } else {
                    Setting::query()
                        ->where('category', 'global')
                        ->where('key', $key)
                        ->update(['value' => $value]);
                }
            }



            $response['success'] = true;
            $response['data'][] = '';
            $response['messages'][] = trans("vaahcms-general.settings_successful_saved");
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
    public function storeLinks(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'links' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];

            $stored_link = Setting::query()
                ->where('category', 'global')
                ->where('type', 'link')
                ->get()->pluck('id')->toArray();

            $input_links = collect($request->links)->pluck('id')->toArray();

            $links_to_delete = array_diff($stored_link, $input_links);

            if(count($links_to_delete)){
                Setting::query()
                    ->whereIn('id', $links_to_delete)
                    ->delete();
            }

            foreach ($request->links as $link) {
                $key = 'link_'.Str::slug($link['label'], '_');

                $setting = Setting::query()
                    ->where('category', 'global')
                    ->where('type', 'link')
                    ->where('key', $key)
                    ->first();

                if (!$setting) {
                    $setting = new Setting();
                }

                $setting->fill($link);
                $setting->key = $key;
                $setting->category = 'global';
                $setting->type = 'link';
                $setting->save();
            }

            $response['success'] = true;
            $response['messages'][] = trans("vaahcms-general.saved");
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
    public function storeMetaTags(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'tags' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];

            foreach ($request->tags as $tag) {

                $setting = Setting::query()
                    ->where('category', 'global')
                    ->where('type', 'meta_tags')
                    ->where('key', $tag['key'])
                    ->first();

                if (!$setting) {
                    $setting = new Setting();
                }

                $setting->fill($tag);
                $setting->category = 'global';
                $setting->type = 'meta_tags';
                $setting->save();
            }

            $response['success'] = true;
            $response['messages'][] = trans("vaahcms-general.saved");
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
    public function deleteMetaTags(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $data = Setting::query()
                ->where('category', 'global')
                ->where('type', 'meta_tags')
                ->where('id',$request->id)->forceDelete();

            $response['success'] = true;
            $response['data'] = $data;
        }  catch (\Exception $e) {
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
