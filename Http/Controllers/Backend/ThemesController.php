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

        if (!Auth::user()->hasPermission('has-access-of-theme-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {

            $data['vaahcms_api_route'] = config('vaahcms.api_route');
            $data['debug'] = config('vaahcms.debug');
            $data['installed'] = Theme::select('slug')->get()->pluck('slug')->toArray();
            $data['rows'] = config('vaahcms.per_page');

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
        if (!Auth::user()->hasPermission('has-access-of-theme-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function download(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-install-theme')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function installUpdates(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-theme')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
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
                    if (!Auth::user()->hasPermission('can-activate-theme')) {
                        $response['success'] = false;
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::activateItem($theme->slug);
                    break;
                //---------------------------------------
                case 'make_default':
                    if (!Auth::user()->hasPermission('can-activate-theme')) {
                        $response['success'] = false;
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::makeItemAsDefault($theme->slug);
                    break;
                //---------------------------------------
                case 'refresh_migrations':
                    if (!Auth::user()->hasPermission('can-activate-theme')) {
                        $response['success'] = false;
                        $response['messages'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::refreshMigrations($theme->slug);
                    break;
                //---------------------------------------
                case 'run_migrations':
                    if (!Auth::user()->hasPermission('can-activate-theme')) {
                        $response['success'] = false;
                        $response['messages'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::runMigrations($theme->slug);
                    break;
                //---------------------------------------
                case 'run_seeds':
                    if (!Auth::user()->hasPermission('can-activate-theme')) {
                        $response['success'] = false;
                        $response['messages'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::runSeeds($theme->slug);
                    break;
                //---------------------------------------
                case 'deactivate':
                    if (!Auth::user()->hasPermission('can-deactivate-theme')) {
                        $response['success'] = false;
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::deactivateItem($theme->slug);
                    break;
                //---------------------------------------
                case 'import_sample_data':
                    if (!Auth::user()->hasPermission('can-import-sample-data-in-theme')) {
                        $response['success'] = false;
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
                    }
                    $response = Theme::importSampleData($theme->slug);
                    break;
                //---------------------------------------
                case 'delete':
                    if (!Auth::user()->hasPermission('can-delete-theme')) {
                        $response['success'] = false;
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
            }
            return response()->json($response);
        }

        $response['data']['item'] = $theme;
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeUpdates(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-theme')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request, $id): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-delete-theme')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
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
            $response['messages'][] = "Something went wrong.";
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
        if (!Auth::user()->hasPermission('can-read-module')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
