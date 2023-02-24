<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use WebReinvent\VaahCms\Entities\Registration;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\User;

class UsersController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        $this->theme = vh_get_backend_theme();
    }
    //----------------------------------------------------------
    public function getAssets(Request $request)
    {

        try{
            if(!\Auth::user()->hasPermission('has-access-of-users-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $role = Role::withTrashed()->select('id','uuid','name','slug')->get();

            $data['country_calling_code'] = vh_get_country_list();
            $data['countries'] = vh_get_country_list();
            $data['timezones'] = vh_get_timezones();
            $data['country_code'] = vh_get_country_list();
            $data['registration_statuses'] = vh_registration_statuses();
            $data['bulk_actions'] = vh_general_bulk_actions();
            $data['name_titles'] = vh_name_titles();
            $data['role'] = $role;
            $data['fields'] = User::getUserSettings();
            $data['custom_fields'] = Setting::where('category','user_setting')
                ->where('label','custom_fields')->first();

            $response['status'] = 'success';
            $response['data'] = $data;

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }


        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postCreate(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-create-users'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }


            $response = User::create($request);


        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getList(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('has-access-of-users-section'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $excluded_columns = User::getUserSettings(true);

            $response = User::getList($request,$excluded_columns);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItem(Request $request, $id)
    {

        try{

            if(!\Auth::user()->hasPermission('can-read-users'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $excluded_columns = User::getUserSettings(true);

            $response = User::getItem($id,$excluded_columns);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getItemRoles(Request $request, $id)
    {

        try{

            if(!\Auth::user()->hasPermission('can-read-users'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = User::getItemRoles($request, $id);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postStore(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-update-users'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $response = User::postStore($request);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function postActions(Request $request, $action)
    {

        try{

            $rules = array(
                'inputs' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = [];

            $request->merge(['action'=>$action]);

            switch ($action)
            {

                //------------------------------------
                case 'bulk-change-status':

                    if(!\Auth::user()->hasPermission('can-manage-users') &&
                        !\Auth::user()->hasPermission('can-update-users'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = User::bulkStatusChange($request);

                    break;
                //------------------------------------
                case 'bulk-trash':

                    if(!\Auth::user()->hasPermission('can-update-users'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = User::bulkTrash($request);

                    break;
                //------------------------------------
                case 'bulk-restore':

                    if(!\Auth::user()->hasPermission('can-update-users'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = User::bulkRestore($request);

                    break;

                //------------------------------------
                case 'bulk-delete':

                    if(!\Auth::user()->hasPermission('can-update-users') ||
                        !\Auth::user()->hasPermission('can-delete-users'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = User::bulkDelete($request);

                    break;
                //------------------------------------
                case 'toggle_role_active_status':

                    if(!\Auth::user()->hasPermission('can-manage-users') &&
                        !\Auth::user()->hasPermission('can-update-users'))
                    {
                        $response['status'] = 'failed';
                        $response['errors'][] = trans("vaahcms::messages.permission_denied");

                        return $response;
                    }

                    $response = User::bulkChangeRoleStatus($request);

                    break;
                //------------------------------------

            }

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function storeAvatar(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-update-users'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $rules = array(
                'user_id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = User::storeAvatar($request, $request->user_id);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function removeAvatar(Request $request)
    {

        try{

            if(!\Auth::user()->hasPermission('can-update-users'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans("vaahcms::messages.permission_denied");

                return response()->json($response);
            }

            $rules = array(
                'user_id' => 'required',
            );

            $validator = \Validator::make( $request->all(), $rules);
            if ( $validator->fails() ) {

                $errors             = errorsToArray($validator->errors());
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            }

            $response = User::removeAvatar($request->user_id);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function getProfile(Request $request)
    {

        try{

            $data['profile'] = User::find(\Auth::user()->id);

            $response['status'] = 'success';
            $response['data'] = $data;
            if(env('APP_DEBUG'))
            {
                $response['hint'][] = '';
            }

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function storeProfile(Request $request)
    {

        try{

            $response = User::storeProfile($request);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }


        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeProfilePassword(Request $request)
    {

        try{

            $response = User::storePassword($request);

            if($response['status'] == 'success')
            {
                \Auth::logout();

                $response['data']['redirect_url'] = route('vh.backend');
            }

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return response()->json($response);
    }
    //----------------------------------------------------------
    public function storeProfileAvatar(Request $request)
    {

        try{

            $response = User::storeAvatar($request);

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }


        return response()->json($response);
    }
    //----------------------------------------------------------
    public function removeProfileAvatar(Request $request)
    {

        try{

            $response = User::removeAvatar();

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }


        return response()->json($response);
    }
    //----------------------------------------------------------


}
