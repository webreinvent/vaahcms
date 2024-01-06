<?php namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use WebReinvent\VaahCms\Models\Permission;
use WebReinvent\VaahCms\Models\Role;

class RolesController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-roles-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $data = [];

            $data['permission'] = [];
            $data['rows'] = config('vaahcms.per_page');

            $data['fillable']['except'] = [
                'uuid',
                'created_by',
                'updated_by',
                'deleted_by',
            ];

            $model = new Role();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column) {
                if ($column === 'is_active') {
                    $data['empty_item'][$column] = 0;
                    continue;
                }

                $data['empty_item'][$column] = null;
            }

            $modules = Permission::withTrashed()->get()->unique('module')->pluck('module');

            $data['actions'] = [];
            $data['modules'] = $modules;

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
        $permission_slug = 'has-access-of-roles-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::getList($request);
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
    public function updateList(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::updateList($request);
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
    public function listAction(Request $request, $type): JsonResponse
    {
        $permission_slugs = ['can-update-roles','can-manage-roles'];

        if(!Auth::user()->hasPermission($permission_slugs[0]) ||
            !Auth::user()->hasPermission($permission_slugs[1])) {
            return response()->json(vh_get_permission_denied_response($permission_slugs));
        }

        try {
            $response = Role::listAction($request, $type);
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
    public function deleteList(Request $request): JsonResponse
    {
        $permission_slug = 'can-delete-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::deleteList($request);
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
    public function createItem(Request $request): JsonResponse
    {
        $permission_slug = 'can-create-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::createItem($request);
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
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::getItem($id);
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
    public function updateItem(Request $request,$id): JsonResponse
    {
        $permission_slug = 'can-update-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::updateItem($request, $id);
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
        $permission_slug = 'can-delete-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::getList($request);
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
    public function itemAction(Request $request, $id, $action): JsonResponse
    {
        $permission_slugs = ['can-manage-roles','can-update-roles'];

        if(!Auth::user()->hasPermission($permission_slugs[0]) ||
            !Auth::user()->hasPermission($permission_slugs[1])) {
            return response()->json(vh_get_permission_denied_response($permission_slugs));
        }

        try {
            $response = Role::itemAction($request, $id, $action);
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
    public function getItemPermission(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::getItemPermission($request, $id);
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
    public function getItemUser(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return response()->json(vh_get_permission_denied_response([$permission_slug]));
        }

        try {
            $response = Role::getItemUser($request, $id);
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
        try {
            $response = Role::postActions($request, $action);
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
    public function getModuleSections(Request $request): JsonResponse
    {
        try {
            $response = Role::getModuleSections($request);
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
