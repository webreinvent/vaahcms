<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use WebReinvent\VaahCms\Entities\FailedJob;
use WebReinvent\VaahCms\Entities\Job;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Http\Controllers\Advanced\LogsController;
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
                        'icon' => 'project-diagram',
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
    public function getDashboardCards()
    {
        $data = [

            "total_users" => [
                "count" => User::count(),
                "icon" => "users",
                "card_classes" => "has-background-primary-light",
                "link" => self::$link."/users/"
            ],

            "active_users" => [
                "count" => User::where('is_active',1)->count(),
                "icon" => "user-check",
                "card_classes" => "has-background-grey-lighter",
                "link" => self::$link."/users/?status=01"
            ],
            "today_login" => [
                "count" => User::whereDate('last_login_at', \Carbon::today())->count(),
                "icon" => "user-edit",
                "card_classes" => "has-background-warning-light"
            ],
            "total_roles" => [
                "count" => Role::count(),
                "icon" => "user-tag",
                "card_classes" => "has-background-danger-light",
                "link" => self::$link."/roles/"
            ],
            "total_admins" => [
                "count" => User::whereHas('roles', function ($query)
                {
                    $query->where('slug', 'administrator');
                    $query->where('vh_user_roles.is_active', 1);
                })->count(),
                "icon" => "users-cog",
                "card_classes" => "has-background-warning-light",
                "link" => self::$link."/users/?roles=administrator"
            ],
            "total_jobs" => [
                "count" => Job::count(),
                "icon" => "briefcase",
                "card_classes" => "has-background-danger-light",
                "link" => self::$link."/advanced/jobs"
            ],
            "failed_jobs" => [
                "count" => FailedJob::count(),
                "icon" => "file-medical-alt",
                "card_classes" => "has-background-primary-light",
                "link" => self::$link."/advanced/jobs-failed"
            ],
            'laravel-'.\Carbon::now()->format('Y-m-d').'.log' => [
                "count" => vh_file_exist(str_replace("\\", "/", storage_path('logs').'\\laravel-'.\Carbon::now()->format('Y-m-d').'.log')),
                "icon" => "clipboard-list",
                "card_classes" => "has-background-grey-lighter",
                "link" => self::$link."/advanced/logs/details/laravel-".\Carbon::now()->format('Y-m-d').'.log'
            ]
        ];

        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
