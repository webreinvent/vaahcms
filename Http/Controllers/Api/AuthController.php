<?php

namespace WebReinvent\VaahCms\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\User;

class AuthController extends Controller
{

    //----------------------------------------------------------
    public function __construct()
    {
    }
    //----------------------------------------------------------
    public function postSignIn(Request $request)
    {

        $rules = array(
            'email' => 'required|max:150',
            'password' => 'required',
        );
        $messages = array(
            'email.required' => trans('vaahcms-login.email_or_username_required'),
            'email.max' => trans('vaahcms-login.email_or_username_limit'),
        );

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            $errors = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $login_response = User::login($request);

        if(isset($login_response['status']) && $login_response['status'] == 'failed')
        {
            return response()->json($login_response);
        }

        $response = [];

        $user = Auth::user()->makeVisible(['api_token']);

        $user->api_token = Str::random(80);
        $user->save();

        $response['status'] = 'success';
        $response['data']['item'] = $user;

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postSignUp(Request $request)
    {

        $inputs = $request->all();

        if(!isset($inputs['status']))
        {
            $inputs['status'] = 'active';
        }

        if(!isset($inputs['is_active']))
        {
            $inputs['is_active'] = 1;
        }

        $rules = array(
            'first_name' => 'required',
            'email' => 'required|max:150',
            'password' => 'required|confirmed'
        );

        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails())
        {
            $errors = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $request_array = [
            'new_item' => $inputs
        ];


        $new_request = new Request($request_array);

        $response = User::create($new_request);
        return response()->json($response);
    }


}
