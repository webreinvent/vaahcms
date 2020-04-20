<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\Module;

class ExtendController extends Controller
{


    //----------------------------------------------------------
    public function __construct()
    {

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
        $base_url = route('vh.backend')."#/";
        $vue_prefix = "vaah";
        $link = $base_url.$vue_prefix;


        $list[0] = [
            'link' => $link,
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
                'link' => $link."/registrations/",
                'label'=> 'Registration'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $list[1]['child'][] =  [
                'link' => $link."/users/",
                'label'=> 'Users'
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $list[1]['child'][] =  [
                'link' => $link."/roles/",
                'label'=> 'Roles'
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1]['child'][] =  [
                'link' => $link."/permissions/",
                'label'=> 'Permissions'
            ];
        }

        $list[2] = [
            'link' => "#",
            'icon' => "cubes",
            'label'=> 'Extend',
            'child' => [
                [
                    'link' => $link."/modules/",
                    'label'=> 'Modules'
                ],
                [
                    'link' => $link."/themes/",
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
                    'link' => route('vh.backend.dashboard'),
                    'label'=> 'Localization'
                ],
            ]
        ];

        $response['status'] = 'success';
        $response['data'] = $list;

        return $response;
    }
    //----------------------------------------------------------


}
