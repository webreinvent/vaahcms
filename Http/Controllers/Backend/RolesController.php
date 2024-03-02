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
            return vh_get_permission_denied_json_response($permission_slug);
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
            $data['language_strings'] = [
                "roles_title" => trans("vaahcms-role.roles_title"),
                "view_users" => trans("vaahcms-role.toolkit_text_view_users"),
                "view_permissions" => trans("vaahcms-role.toolkit_text_view_permissions"),
                "view_permissions_select_a_module" => trans("vaahcms-role.view_permissions_select_a_module"),
                "view_permissions_placeholder_search" =>  trans("vaahcms-role.view_permissions_placeholder_search"),
                "view_permissions_reset_button" =>  trans("vaahcms-role.view_permissions_reset_button"),
                "view_permissions_yes" =>  trans("vaahcms-role.view_permissions_yes"),
                "view_permissions_no" =>  trans("vaahcms-role.view_permissions_no"),
                "view_permissions_text_view" => trans("vaahcms-role.view_permissions_text_view"),
                "view_permissions_active" => trans("vaahcms-role.view_permissions_active"),
                "view_permissions_inactive" => trans("vaahcms-role.view_permissions_inactive"),
                "view_permissions_active_all_permissions" => trans("vaahcms-role.view_permissions_active_all_permissions"),
                "view_permissions_inactive_all_permissions" => trans("vaahcms-role.view_permissions_inactive_all_permissions"),
                "view_users_placeholder_search" => trans("vaahcms-role.view_users_placeholder_search"),
                "view_users_reset_button" => trans("vaahcms-role.view_users_reset_button"),
                "view_users_attach_to_all_users" => trans("vaahcms-role.view_users_attach_to_all_users"),
                "view_users_detach_to_all_users" => trans("vaahcms-role.view_users_detach_to_all_users"),
                "view_users_yes" => trans("vaahcms-role.view_users_yes"),
                "view_users_no" => trans("vaahcms-role.view_users_no"),
                "view_users_text_view" => trans("vaahcms-role.view_users_text_view"),
                "changing_status_dialogue" => trans("vaahcms-role.changing_status_dialogue"),
                "changing_status_message" => trans("vaahcms-role.changing_status_message"),
                "permission_status_cancel_button" => trans("vaahcms-role.permission_status_cancel_button"),
                "permission_status_change_button" => trans("vaahcms-role.permission_status_change_button"),
            ];
            $data['actions'] = [];
            $data['modules'] = $modules;

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
        $permission_slug = 'has-access-of-roles-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Role::getList($request);
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
    public function updateList(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = Role::updateList($request);
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
    public function listAction(Request $request, $type): JsonResponse
    {
        $permission_slugs = ['can-update-roles','can-manage-roles'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request): JsonResponse
    {
        $permission_slug = 'can-delete-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createItem(Request $request): JsonResponse
    {
        $permission_slug = 'can-create-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id): JsonResponse
    {
        $permission_slug = 'can-update-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-delete-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request, $id, $action): JsonResponse
    {
        $permission_slugs = ['can-manage-roles','can-update-roles'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemPermission(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemUser(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-roles';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
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
                $response['errors'][] = trans("vaahcms-general.something_went_wrong");
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
