<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Database\Seeders\VaahCmsTableSeeder;
use WebReinvent\VaahCms\Models\Language;
use WebReinvent\VaahCms\Models\LanguageCategory;
use WebReinvent\VaahCms\Models\LanguageString;

class LocalizationController extends Controller
{
    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $data['rows'] = config('vaahcms.per_page');

            $lang_list = Language::getLangList();

            $data['languages']['list'] = $lang_list;
            $data['languages']['default'] = Language::where('default',1)
                ->first();

            $data['categories']['list'] = LanguageCategory::orderBy('name','asc')
                ->get();
            $data['categories']['default']['id'] = null;

            $data['language_strings'] = [
                "localizations" => trans("vaahcms-localization-setting.localization_heading"),
                "add_language_button" => trans("vaahcms-localization-setting.add_language_button"),
                "add_category_button" => trans("vaahcms-localization-setting.add_category_button"),
                "localization_message" => trans("vaahcms-localization-setting.localization_message"),
                "localization_placeholder_search" => trans("vaahcms-localization-setting.localization_placeholder_search"),
                "localization_placeholder_select_a_category" => trans("vaahcms-localization-setting.localization_placeholder_select_a_category"),
                "localization_placeholder_select_a_filter" => trans("vaahcms-localization-setting.localization_placeholder_select_a_filter"),
                "localization_reset_button" => trans("vaahcms-localization-setting.localization_reset_button"),
                "add_new_languages" => trans("vaahcms-localization-setting.add_new_languages"),
                "add_new_languages_placeholder_name" => trans("vaahcms-localization-setting.add_new_languages_placeholder_name"),
                "add_new_languages_save_button" => trans("vaahcms-localization-setting.add_new_languages_save_button"),
                "localization_empty_value" => trans("vaahcms-localization-setting.localization_empty_value"),
                "localization_filled_value" => trans("vaahcms-localization-setting.localization_filled_value"),
                "add_new_category" => trans("vaahcms-localization-setting.add_new_category"),
                "add_new_category_placeholder_category_name" => trans("vaahcms-localization-setting.add_new_category_placeholder_category_name"),
                "add_new_category_save_button" => trans("vaahcms-localization-setting.add_new_category_save_button"),
                "localization_add_string_button" => trans("vaahcms-localization-setting.localization_add_string_button"),
                "localization_generate_language_files" => trans("vaahcms-localization-setting.localization_generate_language_files"),
                "localization_save_button" => trans("vaahcms-localization-setting.localization_save_button"),
                "no_language_string_exist" => trans("vaahcms-localization-setting.no_language_string_exist"),
                "localization_placeholder_select_a_language" => trans("vaahcms-localization-setting.localization_placeholder_select_a_language"),
                "localization_toolkit_sync" => trans("vaahcms-localization-setting.localization_toolkit_sync"),
                "add_new_languages_placeholder_locale_code" => trans("vaahcms-localization-setting.add_new_languages_placeholder_locale_code"),
                "localization_item_menu" => trans("vaahcms-localization-setting.localization_item_menu"),
                "localization_string_removed" => trans("vaahcms-localization-setting.localization_string_removed"),


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
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = LanguageString::getList($request);
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
    public function generateLanguage(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            LanguageString::syncAndGenerateStrings($request);

            $response = LanguageString::getList($request);
            $response['messages'][] = trans("vaahcms-general.language_file_generated");
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
    public function postStore(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = LanguageString::storeList($request);
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
    public function storeLanguage(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Language::store($request);
            LanguageString::syncStrings($request);
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
    public function storeCategory(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = LanguageCategory::store($request);
            LanguageString::syncStrings($request);
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
    public function postActions(Request $request, $action): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            switch ($action)
            {
                //------------------------------------
                case 'delete-language-string':

                    $response = LanguageString::deleteItem($request);
                    break;
                //------------------------------------
            }
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
    public function runSeeds(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-setting-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {

            $language_seeder = new VaahCmsTableSeeder();

            $language_seeder->seedLanguages();
            $language_seeder->seedLanguageCategories();
            $language_seeder->seedLanguageStrings();

            LanguageString::syncAndGenerateStrings($request);

            $response['messages'][] = trans("vaahcms-general.action_successful");

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
}
