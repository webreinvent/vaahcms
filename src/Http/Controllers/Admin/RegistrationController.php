<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Registration;

class RegistrationController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_admin_theme();
    }

    //----------------------------------------------------------
    public function index()
    {
        return view($this->theme.'.pages.registrations');
    }
    //----------------------------------------------------------
    public function assets(Request $request)
    {

        $reg = new Registration();
        $data['columns'] = $reg->getFormColumns(true);
        $data['debug'] = config('vaahcms.debug');
        $data['country_calling_code'] = vh_get_country_list();
        $data['country'] = vh_get_country_list();
        $data['country_code'] = vh_get_country_list();
        $data['registration_statuses'] = vh_registration_statuses();
        $data['name_titles'] = vh_name_titles();


        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function store(Request $request)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
            'first_name' => 'required',
            'status' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $data = [];

        if($request->has('id'))
        {
            $reg = Registration::find($request->id);
        } else
        {
            $reg = new Registration();
        }

        $reg->fill($request->all());
        $reg->save();


        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
