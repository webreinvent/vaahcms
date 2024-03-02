<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use WebReinvent\VaahCms\Models\Theme;

class ThemesController extends Controller
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
        $permission_slug = 'has-access-of-theme-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {

            $data['vaahcms_api_route'] = config('vaahcms.api_route');
            $data['debug'] = config('vaahcms.debug');
            $data['installed'] = Theme::select('slug')->get()->pluck('slug')->toArray();
            $data['rows'] = config('vaahcms.per_page');
            $data['language_strings'] = [
                "themes_heading" => trans("vaahcms-extend-theme.themes_heading"),
                "themes_install_button" => trans("vaahcms-extend-theme.themes_install_button"),
                "themes_check_updates_button" => trans("vaahcms-extend-theme.themes_check_updates_button"),
                "toolkit_text_reload" => trans("vaahcms-general.toolkit_text_reload"),
                "themes_filter_button" => trans("vaahcms-extend-theme.themes_filter_button"),
                "themes_placeholder_search" => trans("vaahcms-extend-theme.themes_placeholder_search"),
                "themes_reset_button" => trans("vaahcms-extend-theme.themes_reset_button"),
                "themes_filter_all" => trans("vaahcms-extend-theme.themes_filter_all"),
                "themes_filter_active" => trans("vaahcms-extend-theme.themes_filter_active"),
                "themes_filter_inactive" => trans("vaahcms-extend-theme.themes_filter_inactive"),
                "themes_filter_update_available" => trans("vaahcms-extend-theme.themes_filter_update_available"),
                "actions_run_migrations" => trans("vaahcms-extend-module.actions_run_migrations"),
                "actions_run_seeds" => trans("vaahcms-extend-module.actions_run_seeds"),
                "actions_refresh_migrations" => trans("vaahcms-extend-module.actions_refresh_migrations"),
                "themes_name" => trans("vaahcms-extend-theme.themes_name"),
                "themes_version" => trans("vaahcms-extend-theme.themes_version"),
                "themes_developed_by" => trans("vaahcms-extend-theme.themes_developed_by"),
                "themes_toolkit_text_actions" => trans("vaahcms-extend-theme.themes_toolkit_text_actions"),
                "toolkit_text_activate_theme" => trans("vaahcms-extend-theme.toolkit_text_activate_theme"),
                "themes_activate_button" => trans("vaahcms-extend-theme.themes_activate_button"),
                "toolkit_text_deactivate_theme" => trans("vaahcms-extend-theme.toolkit_text_deactivate_theme"),
                "toolkit_text_this_theme_is_marked_as_default" => trans("vaahcms-extend-theme.toolkit_text_this_theme_is_marked_as_default"),
                "themes_toolkit_text_publish_assets" => trans("vaahcms-extend-theme.themes_toolkit_text_publish_assets"),
                "themes_toolkit_text_import_sample_data" => trans("vaahcms-extend-theme.themes_toolkit_text_import_sample_data"),
                "toolkit_text_update_module" => trans("vaahcms-extend-module.toolkit_text_update_module"),
                "update_button" => trans("vaahcms-extend-module.update_button"),


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
        $permission_slug = 'has-access-of-theme-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            Theme::syncAll();

            $list = Theme::orderBy('created_at', 'DESC');

            if ($request->has('filter')) {
                if (array_key_exists('q',$request->filter)) {
                    $list->where(function ($s) use ($request) {
                        $s->where('name', 'LIKE', '%'.$request->filter['q'].'%')
                            ->orWhere('slug', 'LIKE', '%'.$request->filter['q'].'%')
                            ->orWhere('title', 'LIKE', '%'.$request->filter['q'].'%');
                    });
                }

                if (array_key_exists('status',$request->filter) && $request->filter['status'] != 'all') {
                    switch ($request->filter['status'])
                    {
                        case 'active':
                            $list->active();
                            break;
                        case 'inactive':
                            $list->inactive();
                            break;
                        case 'update_available':
                            $list->updateavailable();
                            break;
                    }
                }
            }

            $stats['all'] = $list->count();
            $stats['active'] = Theme::active()->count();
            $stats['inactive'] = Theme::inactive()->count();
            $stats['update_available'] = Theme::updateAvailable()->count();

            $rows = config('vaahcms.per_page');

            if ($request->rows) {
                $rows = $request->rows;
            }

            $response['success'] = true;
            $response['data']['list'] = $list->paginate($rows);
            $response['data']['stats'] = $stats;
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
    public function download(Request $request): JsonResponse
    {
        $permission_slug = 'can-install-theme';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'name' => 'required',
                'download_link' => 'required',
            );

            $validator = \Validator::make( $request->toArray(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = Theme::download($request->name, $request->download_link);
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
    public function installUpdates(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-theme';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'name' => 'required',
                'download_link' => 'required',
            );

            $validator = \Validator::make( $request->toArray(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = Theme::installUpdates($request);
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
    public function actions(Request $request,$id,$action): JsonResponse
    {
        try {
            $request->merge([
                'inputs' => ['id' => $id],
                'action' => $action
            ]);

            $rules = array(
                'action' => 'required',
                'inputs' => 'required',
                'inputs.id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $data = [];
            $inputs = $request->inputs;

            /*
             * Call method from module setup controller
             */
            $theme = Theme::find($inputs['id']);
            if(!in_array($request->action,['run_migrations','run_seeds','refresh_migrations'],TRUE)){
                $method_name = str_replace("_", " ", $action);
                $method_name = ucwords($method_name);
                $method_name = lcfirst(str_replace(" ", "", $method_name));

                $response = vh_theme_action($theme->name, 'SetupController@' . $method_name);
                if (isset($response['success']) && !$response['success']) {
                    return response()->json($response);
                }
            }
            switch($action)
            {
                //---------------------------------------
                case 'activate':
                    $permission_slug = 'can-activate-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::activateItem($theme->slug);
                    break;
                //---------------------------------------
                case 'make_default':
                    $permission_slug = 'can-activate-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::makeItemAsDefault($theme->slug);
                    break;
                //---------------------------------------
                case 'refresh_migrations':
                    $permission_slug = 'can-activate-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::refreshMigrations($theme->slug);
                    break;
                //---------------------------------------
                case 'run_migrations':
                    $permission_slug = 'can-activate-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::runMigrations($theme->slug);
                    break;
                //---------------------------------------
                case 'run_seeds':
                    $permission_slug = 'can-activate-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::runSeeds($theme->slug);
                    break;
                //---------------------------------------
                case 'deactivate':
                    $permission_slug = 'can-deactivate-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::deactivateItem($theme->slug);
                    break;
                //---------------------------------------
                case 'import_sample_data':
                    $permission_slug = 'can-import-sample-data-in-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::importSampleData($theme->slug);
                    break;
                //---------------------------------------
                case 'delete':
                    $permission_slug = 'can-delete-theme';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Theme::deleteItem($theme->slug);
                    break;
                //---------------------------------------
            }
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else {
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
            return response()->json($response);
        }

        $response['data']['item'] = $theme;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeUpdates(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-theme';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'themes' => 'required|array',
            );

            $validator = \Validator::make( $request->all(), $rules);

            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = Theme::storeUpdates($request);
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
    public function deleteItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-delete-theme';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $theme = Theme::where('id',$id)->first();
            $response = Theme::deleteItem($theme->slug);
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
    public function publishAssets(Request $request)
    {
        try {
            $theme = Theme::slug($request->slug)->first();

            $message = Theme::copyAssets($theme);
            $response['data']['item'] = $theme;

            if ($message) {
                $theme->is_assets_published = 1;
                $theme->save();
                $response['success'] = true;
                $response['messages'][] = "Assets published.";

                return $response;
            }

            $response['success']  = false;
            $response['messages'][] = trans("vaahcms-general.something_went_wrong");
            return $response;
        } catch(\Exception $e) {
            $response['success'] = false;
            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            }

            return $response;
        }
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-theme';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Theme::getItem($id);
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
