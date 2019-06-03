<?php

namespace WebReinvent\VaahCms\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

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
        $data['vaahcms_api_route'] = config('vaahcms.api_route');
        $data['debug'] = config('vaahcms.debug');

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);
    }
    //----------------------------------------------------------
        //----------------------------------------------------------
    //----------------------------------------------------------


}
