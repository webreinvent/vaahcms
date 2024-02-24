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
            $response['messages'][] = 'Settings successful saved';
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
            $response['messages'][] = 'Saved';
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
            $response['messages'][] = 'Saved';
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
