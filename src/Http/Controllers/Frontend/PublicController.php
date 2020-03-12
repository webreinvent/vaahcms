<?php

namespace WebReinvent\VaahCms\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\User;

class PublicController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function login()
    {
        return view($this->theme.'.pages.index');
    }

    //----------------------------------------------------------
    public function redirectToLogin()
    {
        return redirect()->route('vh.backend');
    }
    //----------------------------------------------------------
    public function postLogin(Request $request)
    {

        $response = User::login($request);

        if(isset($response['status']) && $response['status'] == 'failed')
        {
            return response()->json($response);
        }

        if ($request->session()->has('accessed_url')) {
            $redirect_url = $request->session()->get('accessed_url');
            $request->session()->forget('accessed_url');
        } else
        {
            $redirect_url = \URL::route('vh.backend.dashboard');
        }

        $response['status'] = 'success';
        $response['messages'][] = 'Login Successful';
        $response['data']['redirect_url'] = $redirect_url;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function logout()
    {
        \Auth::logout();
        return redirect()->route('vh.backend');
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
