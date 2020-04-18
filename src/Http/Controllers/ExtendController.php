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

    public static function extendTopLeftMenu()
    {

        $vue_prefix = "vaah";
        $base_url = route('vh.backend')."#/";
        $dashboard_url = $base_url."vaah/";
        $link = $base_url.$vue_prefix;

        $list[0] = [
            'link' => $dashboard_url,
            'label'=> 'Dashboard'
        ];

        $list[1] = [
            'link' => $dashboard_url,
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
            'link' => route('vh.backend.dashboard'),
            'label'=> 'Settings',
            'child' => [
                [
                    'link' => route('vh.backend.dashboard'),
                    'label'=> 'Localization'
                ],
            ]
        ];



        $active_modules = Module::getActiveModules();

        if($active_modules)
        {
            foreach ($active_modules as $active_module)
            {
                $links = vh_module_action($active_module->name, 'ExtendController@extendTopLeftMenu');

                if($links && is_array($links) && count($links) > 0)
                {
                    $list = array_merge($list, $links);
                }

            }
        }

        return $list;
    }

    //----------------------------------------------------------
    public static function extendTopRightUserMenu()
    {
        $list = [
            [
                'link' => route('vh.backend.logout'),
                'label'=> 'Logout'
            ],
        ];


        $active_modules = Module::getActiveModules();

        if($active_modules)
        {
            foreach ($active_modules as $active_module)
            {
                $links = vh_module_action($active_module->name, 'ExtendController@extendTopRightUserMenu');

                if($links && is_array($links) && count($links) > 0)
                {
                    $list = array_merge($list, $links);
                }

            }
        }

        return $list;
    }
    //----------------------------------------------------------


}
