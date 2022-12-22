<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Models\Role;

class UsersController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }
    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $role = Role::withTrashed()->select('id','uuid','name','slug')->get();

        $data['country_calling_code'] = vh_get_country_list();
        $data['countries'] = vh_get_country_list();
        $data['timezones'] = vh_get_timezones();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = vh_registration_statuses();
        $data['bulk_actions'] = vh_general_bulk_actions();
        $data['name_titles'] = vh_name_titles();
        $data['role'] = $role;
        $data['fields'] = User::getUserSettings();
        $data['custom_fields'] = Setting::where('category','user_setting')
            ->where('label','custom_fields')->first();

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-create-users'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }


        $response = User::create($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $excluded_columns = User::getUserSettings(true);

        $response = User::getList($request,$excluded_columns);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        if(!\Auth::user()->hasPermission('can-read-users'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $excluded_columns = User::getUserSettings(true);

        $response = User::getItem($id,$excluded_columns);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-users'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = User::getItemRoles($request, $id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request)
    {
        if(!\Auth::user()->hasPermission('can-update-users'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = User::postStore($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {
        $rules = array(
            'inputs' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = [];

        $request->merge(['action'=>$action]);

        switch ($action)
        {

            //------------------------------------
            case 'bulk-change-status':

                if(!\Auth::user()->hasPermission('can-manage-users') &&
                    !\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk-trash':

                if(!\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                if(!\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                if(!\Auth::user()->hasPermission('can-update-users') ||
                    !\Auth::user()->hasPermission('can-delete-users'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkDelete($request);

                break;
            //------------------------------------
            case 'toggle_role_active_status':

                if(!\Auth::user()->hasPermission('can-manage-users') &&
                    !\Auth::user()->hasPermission('can-update-users'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = User::bulkChangeRoleStatus($request);

                break;
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function storeAvatar(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-update-users'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'user_id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = User::storeAvatar($request, $request->user_id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function removeAvatar(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-update-users'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $rules = array(
            'user_id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return response()->json($response);
        }


        $response = User::removeAvatar($request->user_id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getProfile(Request $request)
    {

        $data['profile'] = User::find(\Auth::user()->id);

        $data['mfa_methods'] = config('settings.global.mfa_methods');
        $data['mfa_status'] = config('settings.global.mfa_status');

        $response['success'] = true;
        $response['data'] = $data;
        if(env('APP_DEBUG'))
        {
            $response['hint'][] = '';
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function storeProfile(Request $request)
    {
        $response = User::storeProfile($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeProfilePassword(Request $request)
    {
        $response = User::storePassword($request);

        if(isset($response['success']) && $response['success'])
        {
            \Auth::logout();

            $response['data']['redirect_url'] = route('vh.backend');
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeProfileAvatar(Request $request)
    {
        $response = User::storeAvatar($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function removeProfileAvatar(Request $request)
    {
        $response = User::removeAvatar();
        return response()->json($response);
    }
    //----------------------------------------------------------


}
