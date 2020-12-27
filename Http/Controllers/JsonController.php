<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\MenuItem;
use VaahCms\Modules\Cms\Entities\Page;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Notified;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;

class JsonController extends Controller
{



    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getPublicAssets(Request $request)
    {

        $data['vaahcms'] = [
            'name' => config('vaahcms.app_name'),
            'slug' => config('vaahcms.app_slug'),
            'version' => config('vaahcms.version'),
            'website' => config('vaahcms.website'),
            'docs' => config('vaahcms.documentation'),
        ];

        $data['settings'] = [
            'is_mail_settings_not_set' => $this->isMailSettingsNotSet()
        ];


        $data['server'] = [
            'host' => $request->getHost(),
            'current_year' => \Carbon::now()->format('Y'),
            'current_date' => \Carbon::now()->format('Y-m-d'),
            'current_time' => \Carbon::now()->format('H:i:s'),
            'current_date_time' => \Carbon::now()->format('Y-m-d H:i:s'),
            'http' => 'http://',
        ];

        if(\Request::secure())
        {
            $data['server']['http'] = 'https://';
        }

        //-----Vue Errors----------------------
        /*
         * To Set Errors:
         * session(['vue_errors'=>$response['errors']]);
         */
        $data['vue_errors'] = null;
        $vue_errors = session()->get('vue_errors');
        if(isset($vue_errors) && count($vue_errors) > 0)
        {
            $data['vue_errors'] = $vue_errors;
        }
        \Session::forget('vue_errors');
        //-----Vue Errors----------------------

        //-----Vue Messages----------------------
        /*
         * To Set messages:
         * session(['vue_messages'=>$response['messages']]);
         */
        $data['vue_messages'] = null;
        $vue_messages = session()->get('vue_messages');
        if(isset($vue_messages) && count($vue_messages) > 0)
        {
            $data['vue_messages'] = $vue_messages;
        }
        \Session::forget('vue_messages');
        //-----/Vue Messages----------------------


        if(\Auth::check())
        {
            $data['auth_user'] = [
                'name' => \Auth::user()->name,
                'email' => \Auth::user()->email,
            ];

            //-----Vue Backend Notices----------------------
            $data['vue_notices'] = Notified::viaBackend();
            //-----/Vue Backend Notices----------------------

            $data['extended_views'] = $this->getExtendedViews();

        }


        $data['urls']['public'] = url("/");
        $data['urls']['theme'] = vh_get_backend_theme_url();
        $data['urls']['image'] = vh_get_backend_theme_image_url();
        $data['urls']['upload'] = route('vh.backend.media.upload');


        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);


    }
    //----------------------------------------------------------
    public function isLoggedIn(Request $request)
    {


        $data = [];

        $is_logged = false;

        if(\Auth::check())
        {
            $is_logged = true;
        }

        $response['status'] = 'success';
        $response['data']['is_logged_in'] = $is_logged;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function isMailSettingsNotSet()
    {

        $mail_username = env('MAIL_USERNAME');
        $mail_password = env('MAIL_PASSWORD');

        if(
            isset($mail_username) && !empty($mail_username)
            && isset($mail_password) && !empty($mail_password)

        )
        {
            return false;
        }


        return true;

    }
    //----------------------------------------------------------

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissions(Request $request)
    {


        $data = [];

        if(!\Auth::check())
        {
            $response['status'] = 'failed';
            $response['errors'] = [];
            return response()->json($response);
        }

        $response['status'] = 'success';
        $response['data']['list'] = \Auth::user()->permissions(true);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getExtendedViews()
    {

        $locations = [
            'top_left_menu'=>'topLeftMenu',
            'top_right_menu'=>'topRightMenu',
            'top_right_user_menu'=>'topRightUserMenu',
            'sidebar_menu'=>'sidebarMenu',
        ];

        $views = [];
        foreach ($locations as $location=>$method)
        {
            $views[$location] = vh_action($method);
        }


        return $views;
    }
    //----------------------------------------------------------
    public function getUsers(Request $request, $query=null)
    {

        $list = User::where(function($q) use ($query){
            $q->where('first_name', 'LIKE', '%'.$query.'%')
                ->orWhere('last_name', 'LIKE', '%'.$query.'%')
                ->orWhere('email', 'LIKE', '%'.$query.'%')
                ->orWhere('phone', 'LIKE', '%'.$query.'%');
        })->select('id', 'first_name', 'middle_name',
            'last_name', 'display_name', 'email')
            ->take(10)
            ->orderBy('created_at', 'desc')->get();

        return $list;

    }
    //----------------------------------------------------------

    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
