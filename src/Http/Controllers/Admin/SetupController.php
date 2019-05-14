<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SetupController extends Controller
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
        return view($this->theme.'.setup.welcome');
    }

    //----------------------------------------------------------
    public function storeAppInfo(Request $request)
    {
        $rules = array(
            'app_name' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $inputs = $request->all();

        $env_data = \View::make($this->theme.'.setup.partials.setup-env-sample')
            ->with('data', (object)$inputs)->render();

        \Storage::put("../../.env-test", $env_data);

        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data']['env'] = $env_data;

        return response()->json($response);

    }
    //----------------------------------------------------------


}
