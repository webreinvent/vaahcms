<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend\Settings;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
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
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function generateLanguage(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            LanguageString::syncAndGenerateStrings($request);

            $response = LanguageString::getList($request);
            $response['messages'][] = "Language files successfully generated";
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
    public function postStore(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeLanguage(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeCategory(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action): JsonResponse
    {
        $permission_slug = 'has-access-of-setting-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
