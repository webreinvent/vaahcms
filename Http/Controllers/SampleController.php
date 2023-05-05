<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Models\Registration;

class SampleController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {

    }
    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        $data['columns'] = '';

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        $data = [];

        $response['success'] = false;
        $response['errors'][] = 'error';

        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {


        $data = [];

        $response['success'] = false;
        $response['errors'][] = 'error';

        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

        return response()->json($response);

    }

    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        $data = [];

        $response['success'] = false;
        $response['errors'][] = 'error';

        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function postStore(Request $request)
    {
        $data = [];

        $response['success'] = false;
        $response['errors'][] = 'error';

        $response['success'] = true;
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

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
            $response['success'] = false;
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $response = [];

        switch ($request->action)
        {

            //------------------------------------
            case 'bulk_change_status':

                $response = Registration::bulkStatusChange($request);

                break;
            //------------------------------------
            case 'bulk_delete':

                $response = Registration::bulkDelete($request);

                break;
            //------------------------------------
            case 'bulk_restore':

                $response = Registration::bulkRestore($request);

                break;

            //------------------------------------
            //------------------------------------

        }

        return response()->json($response);

    }
    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
