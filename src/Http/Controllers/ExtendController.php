<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Module;

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

        $list[0] = [
            'link' => self::$link,
            'icon' => 'tachometer-alt',
            'label'=> 'Dashboard'
        ];

        $list[1] = [
            'link' => '#',
            'icon' => 'users-cog',
            'label'=> 'Users & Access',
        ];

        if(\Auth::user()->hasPermission('has-access-of-registrations-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/registrations/",
                'label'=> 'Registration'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/users/",
                'label'=> 'Users'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/roles/",
                'label'=> 'Roles'
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1]['child'][] =  [
                'link' => self::$link."/permissions/",
                'label'=> 'Permissions'
            ];
        }

        $list[2] = [
            'link' => "#",
            'icon' => "cubes",
            'label'=> 'Extend',
            'child' => [
                [
                    'link' => self::$link."/modules/",
                    'label'=> 'Modules'
                ],
                [
                    'link' => self::$link."/themes/",
                    'label'=> 'Themes'
                ]
            ]
        ];

        $list[3] = [
            'link' => '#',
            'icon'=> 'cog',
            'label'=> 'Settings',
            'child' => [
                [
                    'link' => self::$link."/settings/general",
                    'label'=> 'General'
                ],
                [
                    'link' => self::$link."/settings/env-variables",
                    'label'=> 'Env Variables'
                ],
                [
                    'link' => self::$link."/settings/localization",
                    'label'=> 'Localization'
                ],
            ]
        ];


        $list[4] = [
            'link' => '#',
            'icon'=> 'photo-video',
            'label'=> 'Manage',
            'child' => [
                [
                    'link' => self::$link."/manage/media",
                    'label'=> 'Media'
                ],
            ]
        ];

        $response['status'] = 'success';
        $response['data'] = $list;

        return $response;
    }
    //----------------------------------------------------------


}
