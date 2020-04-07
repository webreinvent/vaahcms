<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

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

        $list = [
            [
                'link' => $dashboard_url,
                'label'=> 'Dashboard'
            ],
            [
                'link' => $dashboard_url,
                'label'=> 'Users & Access',
                'child' => [
                    [
                        'link' => $link."/registrations/",
                        'label'=> 'Registration'
                    ],
                    [
                        'link' => route('vh.backend.dashboard'),
                        'label'=> 'Users'
                    ],
                    [
                        'link' => route('vh.backend.dashboard'),
                        'label'=> 'Roles'
                    ],
                    [
                        'link' => $link."/permission/",
                        'label'=> 'Permissions'
                    ]
                ]
            ],
            [
                'link' => route('vh.backend.dashboard'),
                'label'=> 'Extend',
                'child' => [
                    [
                        'link' => route('vh.backend.dashboard'),
                        'label'=> 'Modules'
                    ],
                    [
                        'link' => route('vh.backend.dashboard'),
                        'label'=> 'Themes'
                    ]
                ]
            ],
            [
                'link' => route('vh.backend.dashboard'),
                'label'=> 'Settings',
                'child' => [
                    [
                        'link' => route('vh.backend.dashboard'),
                        'label'=> 'Localization'
                    ],
                ]
            ]
        ];

        return $list;
    }

    //----------------------------------------------------------
    public static function extendTopRightUserMenu()
    {
        $list = [
            [
                'link' => route('vh.backend.dashboard'),
                'label'=> 'Logout'
            ],
        ];

        return $list;
    }
    //----------------------------------------------------------


}
