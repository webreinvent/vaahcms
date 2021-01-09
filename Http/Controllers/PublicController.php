<?php

namespace WebReinvent\VaahCms\Http\Controllers;



use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Migration;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\ModuleMigration;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Libraries\VaahSetup;
use WebReinvent\VaahCms\Notifications\TestSmtp;


class PublicController extends Controller
{

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
    public function postGenerateOTP(Request $request)
    {
        $response = User::sendLoginOtp($request);
        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postLogin(Request $request)
    {

        $rules = array(
            'type' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        if($request->type == 'otp')
        {
            $response = User::loginViaOtp($request);
        } else
        {
            $response = User::login($request);
        }

        if(isset($response['status']) && $response['status'] == 'failed')
        {
            return response()->json($response);
        }

        if ($request->session()->has('accessed_url')) {
            $redirect_url = $request->session()->get('accessed_url');
            $request->session()->forget('accessed_url');
        } else
        {
            $redirect_url = \URL::route('vh.backend');
        }

        $response = [];

        $response['status'] = 'success';
        $response['messages'][] = 'Login Successful';
        $response['data']['redirect_url'] = $redirect_url;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function logout()
    {
        if(!\Auth::check())
        {
            return redirect()->route('vh.backend');
        }

        \Auth::logout();

        $redirect_value = config('settings.global.redirect_after_backend_logout');

        if(!isset($redirect_value))
        {
            return redirect()->route('vh.backend');
        }

        $redirect_value_url = '/';

        if($redirect_value != 'frontend'){
            $redirect_value_custom = config('settings.global.redirect_after_backend_logout_url');
            if(isset($redirect_value_custom) && !empty($redirect_value_custom))
            {
                $redirect_value_url = $redirect_value_custom;
            }
        }
        return redirect($redirect_value_url);
    }
    //----------------------------------------------------------
    //----------------------------------------------------------

}
