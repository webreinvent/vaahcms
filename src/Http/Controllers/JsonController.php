<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\MenuItem;
use VaahCms\Modules\Cms\Entities\Page;
use WebReinvent\VaahCms\Entities\Module;
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

        if($request->has('get_server_details'))
        {
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


        if($request->has('get_extended_views') && \Auth::check())
        {
            $data['auth_user'] = [
                'name' => \Auth::user()->name,
                'email' => \Auth::user()->email,
            ];
        }

        if($request->has('get_extended_views'))
        {
            $data['extended_views'] = $this->getExtendedViews();
        }


        $data['urls']['public'] = url("/");
        $data['urls']['theme'] = vh_get_backend_theme_url();
        $data['urls']['image'] = vh_get_backend_theme_image_url();


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
        $modules_views = [];
        $themes_views = [];

        $modules_views = $this->getModulesExtendedViews($locations);
        $themes_views = $this->getThemesExtendedViews($locations);

        foreach ($locations as $key => $location)
        {
            if(!isset($modules_views[$key]))
            {
                $modules_views[$key] = [];
            }
            if(!isset($themes_views[$key]))
            {
                $themes_views[$key] = [];
            }

            $views[$key] = array_filter(array_merge($modules_views[$key], $themes_views[$key]));
        }


        return $views;
    }
    //----------------------------------------------------------
    public function getModulesExtendedViews($locations)
    {

        $active_modules = Module::getActiveModules();


        $ordered = [];

        if($active_modules->count() > 0)
        {

            foreach ($locations as $location=>$method)
            {
                $i = 1;

                if(isset($location)){
                    $settings_name = $location.'_order';
                }

                foreach($active_modules as $item)
                {

                    $settings = $item->settings()->key($settings_name)->first();

                    if($settings && !is_null($settings->value) && $settings->value != "")
                    {
                        $ordered[$location][$settings->value] = $item->slug;
                    } else if($settings && !is_null($settings->id))
                    {
                        $ordered[$location][$settings->id] = $item->slug;
                    } else{
                        $ordered[$location][$i] = $item->slug;
                    }

                    ksort($ordered[$location]);

                    $i++;
                }

            }


        }



        $views = [];

        foreach ($locations as $location=>$method)
        {

            $views[$location] = [];

            $namespace = '\WebReinvent\VaahCms\Http\Controllers\ExtendController';

            $response = vh_action($namespace, $method);


            if($response['status']=='success' && isset($response['data']))
            {
                $views[$location]['vaahcms'] = $response['data'];
            }


            if(isset($ordered[$location]))
            {
                foreach($ordered[$location] as $module_slug)
                {
                    $res = null;

                    $module = Module::where('slug', $module_slug)->where('is_active', 1)
                        ->first();

                    if(!$module)
                    {
                        continue;
                    }


                    $res = vh_module_action($module->name, 'ExtendController@'.$method);

                    if($res['status'] == 'failed')
                    {
                        continue;
                    } elseif(isset($res['status']) && $res['status'] == 'success'
                        && isset($res['data']) && count(array_filter($res['data'])) > 0)
                    {
                        $views[$location][$module->slug] = $res['data'];
                    }


                }
            }


        }

        return $views;
    }
    //----------------------------------------------------------
    public function getThemesExtendedViews($locations)
    {

        $active_themes = Theme::getActiveThemes();


        $ordered = [];

        if($active_themes->count() > 0)
        {

            foreach ($locations as $location=>$method)
            {
                $i = 1;

                if(isset($location)){
                    $settings_name = $location.'_order';
                }

                foreach($active_themes as $item)
                {

                    $settings = $item->settings()->key($settings_name)->first();

                    if($settings && !is_null($settings->value) && $settings->value != "")
                    {
                        $ordered[$location][$settings->value] = $item->slug;
                    } else if($settings && !is_null($settings->id))
                    {
                        $ordered[$location][$settings->id] = $item->slug;
                    } else{
                        $ordered[$location][$i] = $item->slug;
                    }

                    ksort($ordered[$location]);

                    $i++;
                }

            }


        }

        if(count($ordered) < 1 )
        {
            return [];
        }


        $views = [];

        foreach ($locations as $location=>$method)
        {

            if(isset($ordered[$location]))
            {
                foreach($ordered[$location] as $slug)
                {

                    $theme = Theme::where('slug', $slug)->where('is_active', 1)
                        ->first();

                    if(!$theme)
                    {
                        continue;
                    }

                    $res = null;
                    $res = vh_theme_action($theme->name, 'ExtendController@'.$method);

                    if($res['status'] == 'failed')
                    {
                        continue;
                    } elseif(isset($res['status']) && $res['status'] == 'success' && isset($res['data']))
                    {
                        $views[$location][$theme->slug] = $res['data'];
                    }

                }
            }



        }

        return $views;
    }
    //----------------------------------------------------------


}
