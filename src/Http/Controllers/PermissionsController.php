<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;

class PermissionsController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    public function getAssets(Request $request)
    {

        if(!\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $module = Permission::getModuleList();

        $data['country_calling_code'] = vh_get_country_list();
        $data['country'] = vh_get_country_list();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = vh_registration_statuses();
        $data['bulk_actions'] = vh_general_bulk_actions();
        $data['name_titles'] = vh_name_titles();
        $data['module'] = $module;

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request,$id)
    {
        if(!\Auth::user()->hasPermission('can-update-permissions'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Permission::updateDetail($request,$id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-permissions'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Permission::getDetail($id);
        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        if(!\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Permission::getList($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------

    public function getItemRoles(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-manage-permissions') &&
            !\Auth::user()->hasPermission('can-update-permissions') &&
            !\Auth::user()->hasPermission('can-read-permissions'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Permission::getItemRoles($request,$id);
        return response()->json($response);
    }
    //----------------------------------------------------------

    public function getModuleSections(Request $request)
    {
        $response = Permission::getModuleSections($request);
        return response()->json($response);
    }

    //----------------------------------------------------------
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {
        $rules = array(
            'inputs' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = [];

        $response['status'] = 'success';

        $inputs = $request->all();

        switch ($action)
        {

            //------------------------------------
            case 'bulk-change-status':
                $response = Permission::bulkStatusChange($request);
                break;
            //------------------------------------
            case 'bulk-trash':

                $response = Permission::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                $response = Permission::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                $response = Permission::bulkDelete($request);

                break;
            //------------------------------------
            case 'toggle_role_active_status':

                $response = Permission::bulkChangeRoleStatus($request);

                break;
            //------------------------------------
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
