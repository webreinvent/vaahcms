<?php

namespace WebReinvent\VaahCms\Http\Controllers;



use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
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
    public function resetPassword(Request $request,$reset_password_code)
    {

        $reset_password_code_valid = User::where('reset_password_code',$reset_password_code)->first();

        if($reset_password_code_valid){
            $url = \url('/backend#/reset-password/'.$reset_password_code);

            return Redirect::to($url);
        }

        return redirect()->route('vh.backend');
    }

    //----------------------------------------------------------
    public function redirectToLogin()
    {
        return redirect()->route('vh.backend');
    }
    //----------------------------------------------------------
    public function postGenerateOTP(Request $request)
    {
        $response = User::sendLoginOtp($request, 'can-login-in-backend');
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

        $permission_to_check = 'can-login-in-backend';

        if($request->type == 'otp')
        {
            $response = User::loginViaOtp($request, $permission_to_check);
        } else
        {
            $response = User::login($request, $permission_to_check);
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
        $response['data']['verification_response'] = Auth::user()->verifySecurityAuthentication();

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function verifySecurityOtp(Request $request)
    {

        $inputs = [
            'otp_code' => null
        ];

        if(is_array($request->verify_otp))
        {
            $inputs = [
                'otp_code' => implode("", $request->verify_otp)
            ];

        }

        $rules = array(
            'otp_code' => 'required|integer',
        );

        $validator = \Validator::make( $inputs, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }


        $user = auth()->user();

        if($user && !$user->security_code && !$user->security_code_expired_at){
            $response['status'] = 'success';
            $response['messages'][] = 'Login Successful';
            $response['data']['redirect_url'] = route('vh.backend').'#/vaah';
            return $response;
        }

        if($user && $user->security_code_expired_at && $user->security_code_expired_at->lt(now()))
        {
            $user->security_code = null;
            $user->security_code_expired_at = null;
            $user->save();
            auth()->logout();

            $response['status'] = 'failed';
            $response['errors'][] = 'The code has expired. Please login again.';
            $response['data']['redirect_url'] = route('vh.backend');

            return response()->json($response);
        }


        if($user && $inputs['otp_code'] == $user->security_code)
        {
            $user->security_code = null;
            $user->security_code_expired_at = null;
            $user->save();

            $response['status'] = 'success';
            $response['messages'][] = 'Login Successful';
            $response['data']['redirect_url'] = route('vh.backend').'#/vaah';

        }else{
            $response['status'] = 'failed';
            $response['errors'][] = 'Code is not correct.';
        }



        return response()->json($response);

    }
    //----------------------------------------------------------
    public function resendSecurityOtp(Request $request)
    {

        Auth::user()->verifySecurityAuthentication();

        $response = [];

        $response['status'] = 'success';
        $response['data'] = '{}';

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postSendResetCode(Request $request)
    {
        $response = User::sendResetPasswordEmail($request, 'can-login-in-backend');

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function postResetPassword(Request $request)
    {
        $response = User::resetPassword($request);

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

            $redirect_value_url = $redirect_value;

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
