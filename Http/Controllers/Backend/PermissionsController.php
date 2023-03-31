<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use WebReinvent\VaahCms\Models\Permission;

class PermissionsController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        if (!Auth::user()->hasPermission('has-access-of-permissions-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
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

            $model = new Permission();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column)
            {
                $data['empty_item'][$column] = null;
            }

            $data['actions'] = [];

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
        if (!Auth::user()->hasPermission('has-access-of-permissions-section')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::getList($request);
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
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::updateList($request);
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
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::listAction($request, $type);
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
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::deleteList($request);
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
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::getItem($id);
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
    public function updateItem(Request $request, $id): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::updateItem($request, $id);
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
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::deleteItem($request, $id);
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
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::itemAction($request, $id, $action);
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
    public function getItemRoles(Request $request, $id): JsonResponse
    {
        if (!Auth::user()->hasPermission('can-update-permissions')) {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        try {
            $response = Permission::getItemRoles($request, $id);
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
