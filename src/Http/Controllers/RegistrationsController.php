<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Registration;

class RegistrationsController extends Controller
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

        $data['country_calling_code'] = vh_get_country_list();
        $data['countries'] = vh_get_country_list();
        $data['timezones'] = vh_get_timezones();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = vh_registration_statuses();
        $data['bulk_actions'] = vh_general_bulk_actions();
        $data['name_titles'] = vh_name_titles();

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        /*$permission = \Auth::user()->hasPermission('slug');
        if($permission['status'] == 'failed')
        {
            return response()->json($permission);
        }*/


        $response = Registration::create($request);

        if($response['status'] == 'success')
        {
            $list = Registration::getList($request);
            $response['data']['list'] = $list['data']['list'];
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {
        $response = Registration::getList($request);
        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {
        $request->merge(['id'=>$id]);
        $response = Registration::getItem($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request)
    {
        $response = Registration::store($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createUser(Request $request,$id)
    {
        $response = Registration::createUser($id);
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

        switch ($action)
        {

            //------------------------------------
            case 'bulk-change-status':
                $response = Registration::bulkStatusChange($request);
                break;
            //------------------------------------
            case 'bulk-trash':

                $response = Registration::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                $response = Registration::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                $response = Registration::bulkDelete($request);

                break;
            //------------------------------------
            case 'send-verification-mail':

                $response = Registration::sendVerificationEmail($request);

                break;
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
