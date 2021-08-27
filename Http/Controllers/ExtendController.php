<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Libraries\VaahStr;

class ExtendController extends Controller
{

    public static $link;

    //----------------------------------------------------------
    public function __construct()
    {
        $base_url = route('vh.backend')."#/";
        $vue_prefix = "vaah";
        $link = $base_url.$vue_prefix;

        self::$link = $link;
    }

    //----------------------------------------------------------

    public static function topLeftMenu()
    {




        $response['status'] = 'success';
        $response['data'] = [];

        return $response;
    }

    //----------------------------------------------------------
    public static function topRightUserMenu()
    {
        $list = [
            [
                'link' => self::$link."/profile/",
                'label'=> 'Profile'
            ],
            [
                'link' => route('vh.backend.logout'),
                'label'=> 'Logout'
            ],

        ];

        $response['status'] = 'success';
        $response['data'] = $list;

        return $response;
    }
    //----------------------------------------------------------
    public static function sidebarMenu()
    {


        if(\Auth::user()->hasPermission('has-access-of-dashboard'))
        {
            $list[0] = [
                'link' => self::$link,
                'icon' => 'tachometer-alt',
                'label'=> 'Dashboard'
            ];
        }




        if(\Auth::user()->hasPermission('has-access-of-registrations-section') ||
            \Auth::user()->hasPermission('has-access-of-users-section') ||
            \Auth::user()->hasPermission('has-access-of-roles-section') ||
            \Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1] = [
                'link' => '#',
                'icon' => 'users-cog',
                'label'=> 'Users & Access',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-registrations-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/registrations/",
                'icon' => 'user-plus',
                'label'=> 'Registration'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/users/",
                'icon' => 'users',
                'label'=> 'Users'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/roles/",
                'icon' => 'user-tag',
                'label'=> 'Roles'
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/permissions/",
                'icon' => 'key',
                'label'=> 'Permissions'
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-module-section') ||
            \Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[2] = [
                'link' => "#",
                'icon' => "cubes",
                'label'=> 'Extend',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-module-section'))
        {
            $list[2]['child'][] =  [
                'link' => self::$link."/modules/",
                'icon' => 'cube',
                'label'=> 'Modules'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[2]['child'][] =  [
                'link' => self::$link."/themes/",
                'icon' => 'palette',
                'label'=> 'Themes'
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $list[3] = [
                'link' => '#',
                'icon'=> 'cog',
                'label'=> 'Settings',
                'child' => [
                    [
                        'link' => self::$link."/settings/general",
                        'icon' => 'tools',
                        'label'=> 'General'
                    ],
                    [
                        'link' => self::$link."/settings/env-variables",
                        'icon' => 'code',
                        'label'=> 'Env Variables'
                    ],
                    [
                        'link' => self::$link."/settings/localization",
                        'icon' => 'language',
                        'label'=> 'Localization'
                    ],
                    [
                        'link' => self::$link."/settings/notifications",
                        'icon' => 'bell',
                        'label'=> 'Notifications'
                    ],
                ]
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $list[4] = [
                'link' => self::$link."/advanced/logs",
                'icon'=> 'stethoscope',
                'label'=> 'Advanced',

            ];
        }




        if(\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $list[5] = [
                'link' => '#',
                'icon'=> 'photo-video',
                'label'=> 'Manage',
                'child' => [
                    [
                        'link' => self::$link."/manage/media",
                        'icon' => 'file',
                        'label'=> 'Media'
                    ],
                    [
                        'link' => self::$link."/manage/taxonomies",
                        'icon' => 'at',
                        'label'=> 'Taxonomies'
                    ]
                ]
            ];
        }



        $response['status'] = 'success';
        $response['data'] = $list;

        return $response;
    }
    //----------------------------------------------------------
    public function getNotificationVariables()
    {

        $response['status'] = 'success';
        $response['data'] = vh_notification_variables();

        return $response;
    }
    //----------------------------------------------------------
    public function getNotificationActions()
    {

        $response['status'] = 'success';
        $response['data'] = vh_notification_actions();

        return $response;
    }
    //----------------------------------------------------------
    public function translateDynamicStrings($params)
    {
        $string = VaahStr::translateDynamicStrings($params);

        $response['status'] = 'success';
        $response['data'] = $string;

        return $response;

    }
    //----------------------------------------------------------
    public function getPublicUrls()
    {

        $response['status'] = 'success';
        $response['data'] = vh_public_urls();

        return $response;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
