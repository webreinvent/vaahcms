<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Models\Module;

class ModulesController extends Controller
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
        $permission_slug = 'has-access-of-module-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {

            $data['vaahcms_api_route'] = config('vaahcms.api_route');
            $data['debug'] = config('vaahcms.debug');
            $data['installed'] = Module::select('slug')->get()->pluck('slug')->toArray();
            $data['rows'] = config('vaahcms.per_page');

            $data['language_strings'] = [
                "module_title" => trans("vaahcms-sidebar-menu.modules"),
                "toolkit_text_reload" => trans("vaahcms-general.toolkit_text_reload"),
                "check_updates_button" => trans("vaahcms-extend-module.check_updates_button"),
                "install_button" => trans("vaahcms-extend-module.install_button"),
                "filter_button" => trans("vaahcms-extend-module.filter_button"),
                "install_placeholder_search" => trans("vaahcms-extend-module.install_placeholder_search"),
                "filter_all" => trans("vaahcms-extend-module.filter_all"),
                "filter_active" => trans("vaahcms-extend-module.filter_active"),
                "filter_inactive" => trans("vaahcms-extend-module.filter_inactive"),
                "filter_update_available" => trans("vaahcms-extend-module.filter_update_available"),
                "name" => trans("vaahcms-extend-module.name"),
                "version" => trans("vaahcms-extend-module.version"),
                "developed_by" => trans("vaahcms-extend-module.developed_by"),
                "activate_button" => trans("vaahcms-extend-module.activate_button"),
                "toolkit_text_activate_module" => trans("vaahcms-extend-module.toolkit_text_activate_module"),
                "deactivate_button" => trans("vaahcms-extend-module.deactivate_button"),
                "toolkit_text_deactivate_module" => trans("vaahcms-extend-module.toolkit_text_deactivate_module"),
                "toolkit_text_update_module" => trans("vaahcms-extend-module.toolkit_text_update_module"),
                "toolkit_text_import_sample_data" => trans("vaahcms-extend-module.toolkit_text_import_sample_data"),
                "toolkit_text_publish_assets" => trans("vaahcms-extend-module.toolkit_text_publish_assets"),
                "toolkit_text_actions" => trans("vaahcms-extend-module.toolkit_text_actions"),
                "actions_run_migrations" => trans("vaahcms-extend-module.actions_run_migrations"),
                "actions_run_seeds" => trans("vaahcms-extend-module.actions_run_seeds"),
                "actions_refresh_migrations" => trans("vaahcms-extend-module.actions_refresh_migrations"),
                "update_button" => trans("vaahcms-extend-module.update_button"),
                "install_modules" => trans("vaahcms-extend-module.install_modules"),
                "installed_button" => trans("vaahcms-extend-module.installed_button"),

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
        $permission_slug = 'has-access-of-module-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            Module::syncAllModules();
            $list = Module::orderBy('created_at', 'DESC');

            if($request->has('filter'))
            {
                if(array_key_exists('q',$request->filter)) {
                    $list->where(function ($s) use ($request) {
                        $s->where('name', 'LIKE', '%'.$request->filter['q'].'%')
                            ->orWhere('slug', 'LIKE', '%'.$request->filter['q'].'%')
                            ->orWhere('title', 'LIKE', '%'.$request->filter['q'].'%');
                    });
                }

                if(array_key_exists('status',$request->filter) && $request->filter['status'] != 'all')
                {
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
            $stats['active'] = Module::active()->count();
            $stats['inactive'] = Module::inactive()->count();
            $stats['update_available'] = Module::updateAvailable()->count();

            $response['success'] = true;

            $rows = config('vaahcms.per_page');

            if ($request->rows)
            {
                $rows = $request->rows;
            }

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
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-module';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Module::getItem($id);
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
        $permission_slug = 'can-install-module';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'name' => 'required',
                'download_link' => 'required',
            );

            $validator = \Validator::make( $request->toArray(), $rules);
            if ($validator->fails()) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = Module::download($request->name, $request->download_link);
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
        $permission_slug = 'can-update-module';

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
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = Module::installUpdates($request);
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
    public function actions(Request $request, $id, $action): JsonResponse
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
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $data = [];
            $inputs = $request->inputs;

            $module = Module::find($inputs['id']);
            /*
             * Call method from module setup controller
             */
            if(!in_array($request->action,['run_migrations','run_seeds','refresh_migrations'],TRUE)){

                $method_name = str_replace("_", " ", $request->action);
                $method_name = ucwords($method_name);
                $method_name = lcfirst(str_replace(" ", "", $method_name));

                $response = vh_module_action($module->name, 'SetupController@'.$method_name);
                if (isset($response['success']) && !$response['success']) {
                    return response()->json($response);
                }
            }

            switch($request->action)
            {
                //---------------------------------------
                case 'activate':
                    $permission_slug = 'can-activate-module';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Module::activateItem($module->slug);
                    break;
                //---------------------------------------
                case 'deactivate':
                    $permission_slug = 'can-deactivate-module';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }

                    $response = Module::deactivateItem($module->slug);
                    break;
                //---------------------------------------
                case 'refresh_migrations':
                    $permission_slug = 'can-activate-module';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Module::refreshMigrations($module->slug);
                    break;
                //---------------------------------------
                case 'run_migrations':
                    $permission_slug = 'can-activate-module';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Module::runMigrations($module->slug);
                    break;
                //---------------------------------------
                case 'run_seeds':
                    $permission_slug = 'can-activate-module';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }
                    $response = Module::runSeeds($module->slug);
                    break;
                //---------------------------------------
                case 'import_sample_data':
                    $permission_slug = 'can-import-sample-data-in-module';

                    if(!\Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }

                    $response = Module::importSampleData($module->slug);
                    break;
                //---------------------------------------
                case 'delete':
                    $permission_slug = 'can-delete-module';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }

                    $response = Module::deleteItem($module->slug);
                    break;
                //---------------------------------------
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

        $response['data']['item'] = $module;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function callModuleControllerMethod($module, $controller, $method): JsonResponse
    {
        $response = [];
        try {
            if (isset($method) && method_exists($controller, $method)
                && is_callable(array($controller, $method)))
            {
                $response = call_user_func($controller."::".$method, $module);
                $response['data']['controller_method'] = $controller;
            }
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
    public function getModulesSlugs(Request $request): JsonResponse
    {
        try {
            $module_slugs = Module::all()->pluck('slug')->toArray();

            $module_slugs = implode(",", $module_slugs);

            $response['success'] = true;
            $response['data'] = $module_slugs;

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
    public function updateModuleVersions(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-module';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            if (!$request->has('modules')) {
                $response['success'] = true;
                return response()->json($response);
            }

            foreach ($request->get('modules') as $module) {
                $installed_module = Module::where('slug', $module['slug'])->first();

                if ($installed_module->version_number < $module['version_number']) {
                    $installed_module->is_update_available = 1;
                    $installed_module->update_checked_at = Carbon::now();
                    $installed_module->save();
                }
            }

            $response['success'] = true;
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
    public function storeUpdates(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-module';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'modules' => 'required|array',
            );

            $validator = \Validator::make( $request->all(), $rules);

            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = Module::storeUpdates($request);
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
    public function publishAssets(Request $request): JsonResponse
    {
        try {
            $module = Module::slug($request->slug)->first();

            $message = Module::copyAssets($module);
            $response['data']['item'] = $module;
            if ($message) {
                $module->is_assets_published = 1;
                $module->save();
                $response['success'] = true;
                $response['messages'][] = "Assets published.";
                return response()->json($response);
            }

            $response['success'] = false;
            $response['errors'][] = "Something went wrong.";
        } catch(\Exception $e) {
            $response['success'] = false;
            $response['errors'][] = $e->getMessage();
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
