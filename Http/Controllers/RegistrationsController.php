<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\Taxonomy;
use WebReinvent\VaahCms\Entities\User;

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

        if(!\Auth::user()->hasPermission('has-access-of-registrations-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $data['country_calling_code'] = vh_get_country_list();
        $data['countries'] = vh_get_country_list();
        $data['timezones'] = vh_get_timezones();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = Taxonomy::getTaxonomyByType('registrations');
        $data['bulk_actions'] = vh_general_bulk_actions();
        $data['name_titles'] = vh_name_titles();
        $data['fields'] = User::getUserSettings();
        $data['custom_fields'] = Setting::where('category','user_setting')
            ->where('label','custom_fields')->first();

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-create-registrations'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

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
        if(!\Auth::user()->hasPermission('has-access-of-registrations-section'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $excluded_columns = User::getUserSettings(true,true);

        $response = Registration::getList($request,$excluded_columns);
        return response()->json($response);
    }

    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        if(!\Auth::user()->hasPermission('can-read-registrations'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $excluded_columns = User::getUserSettings(true,true);

        $request->merge(['id'=>$id]);
        $response = Registration::getItem($request,$excluded_columns);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function createUser(Request $request,$id)
    {
        if(!\Auth::user()->hasPermission('can-create-users-from-registrations'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return $response;
        }

        $response = Registration::createUser($id);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request)
    {

        if(!\Auth::user()->hasPermission('can-update-registrations'))
        {
            $response['status'] = 'failed';
            $response['errors'][] = trans("vaahcms::messages.permission_denied");

            return response()->json($response);
        }

        $response = Registration::postStore($request);
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

                if(!\Auth::user()->hasPermission('can-manage-registrations') &&
                    !\Auth::user()->hasPermission('can-update-registrations'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Registration::bulkStatusChange($request);
                break;
            //------------------------------------
            case 'bulk-trash':

                if(!\Auth::user()->hasPermission('can-update-registrations'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Registration::bulkTrash($request);

                break;
            //------------------------------------
            case 'bulk-restore':

                if(!\Auth::user()->hasPermission('can-update-registrations'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Registration::bulkRestore($request);

                break;

            //------------------------------------
            case 'bulk-delete':

                if(!\Auth::user()->hasPermission('can-update-registrations') ||
                    !\Auth::user()->hasPermission('can-delete-registrations'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

                $response = Registration::bulkDelete($request);

                break;
            //------------------------------------
            case 'send-verification-mail':

                if(!\Auth::user()->hasPermission('can-manage-registrations') &&
                    !\Auth::user()->hasPermission('can-update-registrations'))
                {
                    $response['status'] = 'failed';
                    $response['errors'][] = trans("vaahcms::messages.permission_denied");

                    return $response;
                }

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
