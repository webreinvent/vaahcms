<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;

class RolesController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.pages.roles');
    }

    public function getAssets(Request $request)
    {
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

    //----------------------------------------------------------
    public function postCreate(Request $request)
    {
        $response = Role::create($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request,$id)
    {
        $response = Role::updateDetail($request,$id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        $response = Role::getDetail($id);
        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = Role::getList($request);
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

                $response = Role::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk-trash':

                $response = Role::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                $response = Role::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                $response = Role::bulkDelete($request);

                break;
            //------------------------------------
            case 'toggle_permission_active_status':

                $response = Role::bulkChangePermissionStatus($request);

                break;
            //------------------------------------
            case 'toggle_user_active_status':

                $response = Role::bulkChangeUserStatus($request);

                break;
            //------------------------------------
            case 'change-role-permission-status':

                $response = Role::bulkPermissionStatusChange($request);
                break;
            //------------
            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getItemPermission(Request $request, $id)
    {
        $response = Role::getRolePermission($request, $id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemUser(Request $request, $id)
    {
        $response = Role::getRoleUser($request, $id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
