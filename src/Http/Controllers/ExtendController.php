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
        $list = [
            [
                'link' => route('vh.backend.dashboard'),
                'label'=> 'Dashboard'
            ],
            [
                'link' => route('vh.backend.dashboard'),
                'label'=> 'Users & Access',
                'child' => [
                    [
                        'link' => route('vh.backend.dashboard'),
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
                        'link' => route('vh.backend.dashboard'),
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
