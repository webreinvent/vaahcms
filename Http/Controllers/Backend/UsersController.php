<?php

namespace WebReinvent\VaahCms\Http\Controllers\Backend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\Taxonomy;
use WebReinvent\VaahCms\Models\User;

class UsersController extends Controller
{
    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function getAssets(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-users-section';

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

            $model = new User();
            $fillable = $model->getFillable();
            $data['fillable']['columns'] = array_diff(
                $fillable, $data['fillable']['except']
            );

            foreach ($fillable as $column) {
                $data['empty_item'][$column] = null;
            }

            $custom_fields = Setting::query()->where('category','user_setting')
                ->where('label','custom_fields')->first();

            $data['empty_item']['meta']['custom_fields'] = [];

            if (isset($custom_fields)) {
                foreach ($custom_fields['value'] as $custom_field) {
                    $data['empty_item']['meta']['custom_fields'][$custom_field->slug] = null;
                }
            }

            $roles_count = Role::all()->count();

          //---------------------------------------------------

            $data['language_strings'] = [
                "page_title" => trans("vaahcms-user.users_title"),
                "view_role_active_all_roles" => trans("vaahcms-user.view_role_active_all_roles"),
                "view_role_inactive_all_roles" => trans("vaahcms-user.view_role_inactive_all_roles"),
                "view_generate_new_api_token" => trans("vaahcms-user.view_generate_new_api_token"),
                "view_role_yes" => trans("vaahcms-user.view_role_yes"),
                "view_role_no" => trans("vaahcms-user.view_role_no"),
                "view_role_text_view" => trans("vaahcms-user.view_role_text_view"),
                "view_role_placeholder_search" => trans("vaahcms-user.view_role_placeholder_search"),
                "view_role_reset_button" => trans("vaahcms-user.view_role_reset_button"),
                "toolkit_text_impersonate" => trans("vaahcms-user.toolkit_text_impersonate"),
            ];

            //---------------------------------------------------
            $data['actions'] = [];
            $data['name_titles'] = vh_name_titles();
            $data['countries'] = vh_get_country_list();
            $data['timezones'] = vh_get_timezones();
            $data['custom_fields'] = $custom_fields;
            $data['fields'] = User::getUserSettings();
            $data['totalRole'] = $roles_count;
            $data['country_code'] = vh_get_country_list();
            $data['registration_statuses'] = Taxonomy::getTaxonomyByType('registrations');
            $response['success'] = true;
            $response['data'] = $data;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request): JsonResponse
    {
        $permission_slug = 'has-access-of-users-section';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = User::getList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateList(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = User::updateList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function listAction(Request $request, $type): JsonResponse
    {
        $permission_slug = 'can-update-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = User::listAction($request, $type);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteList(Request $request): JsonResponse
    {
        try {
            $response = User::deleteList($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createItem(Request $request): JsonResponse
    {

        $permission_slug = 'can-create-user';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = User::createItem($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = User::getItem($id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function updateItem(Request $request,$id): JsonResponse
    {
        $permission_slug = 'can-update-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {

            $item = User::query()->where('id', $id)->first();

            if (!$item) {
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.registration_not_found');
                return response()->json($response);
            }

            $request['id'] = $item->id;
            $response = User::updateItem($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function deleteItem(Request $request,$id): JsonResponse
    {
        $permission_slugs = ['can-update-users','can-delete-users'];
        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {
            $is_restricted = User::restrictedActions('delete', $id);

            if(isset($is_restricted['success']) && !$is_restricted['success'])
            {
                $response['success'] = false;
                $response['errors'] = $is_restricted['errors'];
                return response()->json($response);
            }
            $response = User::deleteItem($request, $id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function itemAction(Request $request,$id,$action): JsonResponse
    {
        $permission_slugs = ['can-manage-users','can-update-users'];

        $permission_response = Auth::user()->hasPermissions($permission_slugs);

        if(isset($permission_response['success']) && $permission_response['success'] == false) {
            return response()->json($permission_response);
        }

        try {

            $is_restricted = User::restrictedActions($action, $id);

            if(isset($is_restricted['success']) && !$is_restricted['success'])
            {
                $response =  User::getItem($id);
                $response['errors'] = $is_restricted['errors'];
                return response()->json($response);
            }

            $response = User::itemAction($request,$id,$action);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request, $id): JsonResponse
    {
        $permission_slug = 'can-read-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $item = User::withTrashed()->where('id', $id)->first();

            $response['data']['item'] = $item;

            if ($request->has("q")) {
                $list = $item->roles()->where(function ($q) use ($request){
                    $q->where('name', 'LIKE', '%'.$request->q.'%')
                        ->orWhere('slug', 'LIKE', '%'.$request->q.'%');
                });
            } else {
                $list = $item->roles();
            }

            $list->orderBy('pivot_is_active', 'desc');
            $rows = config('vaahcms.per_page');

            if ($request->rows) {
                $rows = $request->rows;
            }

            $list = $list->paginate($rows);

            foreach ($list as $role) {

                $data = User::getPivotData($role->pivot);

                $role['json'] = $data;
                $role['json_length'] = count($data);
            }

            $response['data']['list'] = $list;
            $response['success'] = true;
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action) : JsonResponse
    {
        try {
            $rules = array(
                'inputs' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = [];

            $request->merge(['action'=>$action]);

            switch ($action)
            {
                //------------------------------------
                case 'bulk-change-status':

                    $permission_slugs = ['can-manage-users','can-update-users'];

                    $permission_response = Auth::user()->hasPermissions($permission_slugs);

                    if(isset($permission_response['success']) && $permission_response['success'] == false) {
                        return response()->json($permission_response);
                    }

                    $response = User::bulkStatusChange($request);

                    break;
                //------------------------------------
                case 'bulk-trash':

                    $permission_slug = 'can-update-users';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }

                    $response = User::bulkTrash($request);

                    break;
                //------------------------------------
                case 'bulk-restore':

                    $permission_slug = 'can-update-users';

                    if(!Auth::user()->hasPermission($permission_slug)) {
                        return vh_get_permission_denied_json_response($permission_slug);
                    }

                    $response = User::bulkRestore($request);

                    break;
                //------------------------------------
                case 'bulk-delete':

                    $permission_slugs = ['can-update-users','can-delete-users'];
                    $permission_response = Auth::user()->hasPermissions($permission_slugs);

                    if(isset($permission_response['success']) && $permission_response['success'] == false) {
                        return response()->json($permission_response);
                    }

                    $response = User::bulkDelete($request);

                    break;
                //------------------------------------
                case 'toggle-role-active-status':

                    $permission_slugs = ['can-manage-users','can-update-users'];
                    $permission_response = Auth::user()->hasPermissions($permission_slugs);

                    if(isset($permission_response['success']) && $permission_response['success'] == false) {
                        return response()->json($permission_response);
                    }

                    $response = User::bulkChangeRoleStatus($request);

                    break;
                //------------------------------------
            }
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeAvatar(Request $request): JsonResponse
    {
        $permission_slug = 'can-update-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'user_id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = User::storeAvatar($request, $request->user_id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function removeAvatar(Request $request)
    {
        $permission_slug = 'can-update-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $rules = array(
                'user_id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {
                $errors = errorsToArray($validator->errors());
                $response['success'] = false;
                $response['errors'][] = $errors;
                return response()->json($response);
            }

            $response = User::removeAvatar($request->user_id);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['messages'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function impersonate(Request $request, $uuid): JsonResponse
    {
        $permission_slug = 'can-impersonate-users';

        if(!Auth::user()->hasPermission($permission_slug)) {
            return vh_get_permission_denied_json_response($permission_slug);
        }

        try {
            $response = [];
            $user = User::where('uuid', $uuid)->first();


            if(!$user){
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.user_does_not_exist');
                return response()->json($response);
            }

            if($user->is_active != 1){
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.user_is_not_active');
                return response()->json($response);
            }

            if(!$user->hasPermission('can-login-in-backend')){
                $response['success'] = false;
                $response['errors'][] = trans('vaahcms-user.impersonate_permission_denied');
                return response()->json($response);
            }

            Auth::user()->impersonate($user);

            $response['success'] = true;
            $response['redirect_url'] = route('vh.backend').'#/vaah';


        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function impersonateLogout(Request $request): JsonResponse
    {

        try {

            Auth::user()->leaveImpersonation();

            $response = [];
            $response['success'] = true;
            $response['data'] = '';


        } catch (\Exception $e) {


            $response = [];
            $response['success'] = false;

            if (env('APP_DEBUG')) {
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTraceAsString();
            } else {
                $response['errors'][] = trans('vaahcms-general.something_went_wrong');
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
}
