<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Taxonomy;
use WebReinvent\VaahCms\Models\Permission;

class RolesController extends Controller
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

        if(!\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $module = Permission::withTrashed()->select('module')->get()->unique('module');

        $data['country_calling_code'] = vh_get_country_list();
        $data['country'] = vh_get_country_list();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = vh_registration_statuses();
        $data['bulk_actions'] = vh_general_bulk_actions();
        $data['name_titles'] = vh_name_titles();
        $data['module'] = $module;
        $data['types'] = Taxonomy::getTaxonomyByType('roles');

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    public function postCreate(Request $request)
    {
        if(!\Auth::user()->hasPermission('can-create-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Role::create($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        if(!\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Role::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Role::getItem($id);
        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getItemPermission(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Role::getRolePermission($request, $id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemUser(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Role::getRoleUser($request, $id);
        return response()->json($response);
    }
    //----------------------------------------------------------

    public function getModuleSections(Request $request)
    {
        $response = Role::getModuleSections($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request,$id)
    {
        if(!\Auth::user()->hasPermission('can-update-roles'))
        {
            $response['success'] = false;
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Role::postStore($request,$id);
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

        switch ($action)
        {

            //------------------------------------
            case 'bulk-change-status':

                if(!\Auth::user()->hasPermission('can-manage-roles') &&
                    !\Auth::user()->hasPermission('can-update-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk-trash':

                if(!\Auth::user()->hasPermission('can-update-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':


                if(!\Auth::user()->hasPermission('can-update-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                if(!\Auth::user()->hasPermission('can-update-roles') ||
                    !\Auth::user()->hasPermission('can-delete-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkDelete($request);

                break;
            //------------------------------------
            case 'toggle_permission_active_status':

                if(!\Auth::user()->hasPermission('can-manage-roles') &&
                    !\Auth::user()->hasPermission('can-update-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkChangePermissionStatus($request);

                break;
            //------------------------------------
            case 'toggle_user_active_status':

                if(!\Auth::user()->hasPermission('can-manage-roles') &&
                    !\Auth::user()->hasPermission('can-update-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkChangeUserStatus($request);

                break;
            //------------------------------------
            case 'change-role-permission-status':

                if(!\Auth::user()->hasPermission('can-manage-roles') &&
                    !\Auth::user()->hasPermission('can-update-roles'))
                {
                    $response['success'] = false;
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Role::bulkPermissionStatusChange($request);
                break;
            //------------
            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
