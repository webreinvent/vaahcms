<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;



use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Libraries\VaahHelper;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\User;


class PublicController extends Controller
{

    //----------------------------------------------------------

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
                $response['success'] = true;
                $response['message'][] = 'MFA disabled successfully.';
                return $response;

            }

            $response['success'] = false;
            $response['errors'][] = 'Api Token not matched.';
            return $response;

        }

        $response['success'] = false;
        $response['errors'][] = 'User not found.';
        return $response;

    }
    //----------------------------------------------------------

}
