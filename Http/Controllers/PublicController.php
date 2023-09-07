<?php

namespace WebReinvent\VaahCms\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Models\Registration;
use WebReinvent\VaahCms\Models\RegistrationBase;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\User;


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
    public function verifyEmail(Request $request,$activation_code)
    {

        $reg = Registration::where('activation_code',$activation_code)->first();

        $verify_response = [];

        if(!$reg){

            $verify_response['status'] = 'failed';
            $verify_response['error'] = 'Registration not found.';
            return redirect()->to(
                $this->setUrlQuery(url('/backend#/'),$verify_response)
            );

        }

        $request_item = new Request(['can_send_mail' => true]);

        $response = Registration::createUser($request_item,$reg->id);

        if(isset($response['success']) && !$response['success']){
            $verify_response['status'] = 'failed';
            $verify_response['error'] = $response['messages'][0];

            return redirect()->to(
                $this->setUrlQuery(url('/backend#/'),$verify_response)
            );

        }

        $reg->activation_code = null;
        $reg->status = 'user-created';
        $reg->save();

        $verify_response['status'] = 'success';
        $verify_response['message'] = 'Successfully verified and You can login now.';
        return redirect()->to(
            $this->setUrlQuery(url('/backend#/'),$verify_response)
        );



    }

    //----------------------------------------------------------
    public function setUrlQuery(String $url,Array $response)
    {
        return  Str::finish($url, '?') . Arr::query($response);
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

        try{

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
            if(isset($response['success']) && !$response['success'])
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

            $verify_response = Auth::user()->verifySecurityAuthentication();

            if(isset($verify_response['success'])
                && !$verify_response['success']
                && $verify_response['data'] != null){

                return $verify_response;
            }

            $message = 'Login Successful';

            $response = [];

            $response['success'] = true;
            $response['messages'][] = $message;
            $response['data']['redirect_url'] = $redirect_url;
            $response['data']['verification_response'] = $verify_response;

        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }


        return response()->json($response);

    }
    //----------------------------------------------------------
    public function verifySecurityOtp(Request $request)
    {
        $inputs = [
            'otp_code' => null
        ];

        if($request->verification_otp)
        {
            $inputs = [
                'otp_code' => $request->verification_otp
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

        if($user && $user->security_code_expired_at
            && $user->security_code_expired_at->lt(now()))
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

        $verify_response = Auth::user()->verifySecurityAuthentication();

        if(isset($verify_response['success']) && !$verify_response['success']){
            return $verify_response;
        }

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
    public function disableMfa(Request $request,$token)
    {

        $user = User::first();

        if($user){
            if($user->api_token && $user->api_token ==  $token){

                $mfa_status_setting = Setting::where('key','mfa_status')->first();
                if($mfa_status_setting){
                    $mfa_status_setting->value = 'disable';
                    $mfa_status_setting->save();
                }

                $mfa_methods_setting = Setting::where('key','mfa_methods')->first();
                if($mfa_methods_setting){
                    $mfa_methods_setting->value = ["email-otp-verification"];
                    $mfa_methods_setting->type = 'json';
                    $mfa_methods_setting->save();
                }

                //clear cache
                VaahHelper::clearCache();

                $response = [];
                $response['status'] = 'success';
                $response['message'][] = 'MFA disabled successfully.';
                return $response;

            }

            $response['status'] = 'failed';
            $response['errors'][] = 'Api Token not matched.';
            return $response;

        }

        $response['status'] = 'failed';
        $response['errors'][] = 'User not found.';
        return $response;

    }

    public function getAdminToken(Request $request)
    {

        $user = User::first();

        if($user){
            if($user->api_token){
                return $user->api_token;
            }

            $token = \Str::random(30);

            $user->api_token = $token;
            $user->save();

            return $token;
        }

    }
    //----------------------------------------------------------
    public function postSignup(Request $request)
    {
        try{
            return RegistrationBase::createRegistration($request);
        } catch (\Exception $e) {
            $response = [];
            $response['success'] = false;

            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'][] = $e->getTrace();
            } else {
                $response['errors'][] = 'Something went wrong.';
            }
        }


        return response()->json($response);

    }
    //----------------------------------------------------------
    //----------------------------------------------------------

}
