<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Entities\FailedJob;
use WebReinvent\VaahCms\Entities\Job;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;
use WebReinvent\VaahCms\Entities\Theme;
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
                'label'=> 'Dashboard',
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
                        'link' => self::$link."/settings/user-settings",
                        'icon' => 'users-cog',
                        'label'=> 'User Settings'
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
                    [
                        'link' => self::$link."/settings/update",
                        'icon' => 'download',
                        'label'=> 'Update'
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
    public function getDashboardItems()
    {

        $data = array();

        $data['card'] = [
            "title" => "Users and Roles",
            "list" => [
                [
                    "count" => User::count(),
                    "label" => 'Total User',
                    "icon" => "user",
                    "type" => "info",
                    "link" => self::$link."/users/"
                ],
                [
                    "count" => Role::count(),
                    "label" => 'Total Role',
                    "icon" => "user",
                    "type" => "danger",
                    "link" => self::$link."/roles/"
                ],
                [
                    "count" => Permission::count(),
                    "label" => 'Total Permission',
                    "icon" => "user",
                    "type" => "warning",
                    "link" => self::$link."/permissions/"
                ],
                [
                    "count" => User::where('is_active',1)->count(),
                    "label" => 'Active Users',
                    "icon" => "user",
                    "type" => "success",
                    "link" => self::$link."/users?status=active"
                ]
            ]

        ];


        $log_list = [];


        /*$logs = new LogsController();

        $log_list = $logs->getList(new Request());

        if(isset($log_list->original) && $log_list->original['status'] == 'success'){
            $log_list = $log_list->original['data']['list'];
        }*/


        $data['expanded_item'] = [
            [
                'title' => 'Jobs',
                'type' => 'content',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,
                 when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'footer' => [
                    [
                        'name' => 'Pending',
                        'count' => Job::count(),
                        'type' => 'info',
                        'icon' => 'envelope',
                        'link' => self::$link."/advanced/jobs/",
                    ],
                    [
                        'name' => 'Failed',
                        'count' => FailedJob::count(),
                        'type' => 'danger',
                        'icon' => 'ban',
                        'link' => self::$link."/advanced/jobs-failed/",
                    ]
                ]
            ],
            [
                'title' => 'Laravel Logs',
                'type' => 'list',
                'list' => $log_list,
                'list_limit' => 5,
                'link_text' => "View all recent logs",
                'link' => self::$link."/advanced/logs/",
            ]
        ];


        $data['expanded_header_links'] = [
            [
                'name' => 'Check Updates',
                'icon' => 'redo-alt',
                'link' => self::$link."/settings/update"
            ],
            [
                'name' => 'Getting Started',
                'icon' => 'play-circle',
                'link' => 'https://docs.vaah.dev/vaahcms/installation.html'
            ]
        ];


        $data['has_activated_theme'] = Theme::where('is_active',1)->exists();



        $data['next_steps'] = [
            [
                'name' => 'View your Site',
                'icon' => 'tv',
                'link' => url('/')
            ]
        ];


        $data['actions'] = [
            [
                'name' => 'Manage your Module',
                'icon' => 'cube',
                'link' => self::$link."/modules"
            ]
        ];



        /*$data = [

            [
                "image" => Auth::user()->avatar,
                "column" => 'is-6',
                "label" => 'Hello, '.Auth::user()->name,
                "card_classes" => "has-background-warning-light",
                "link" => self::$link."/users/view/".Auth::user()->id
            ],
            [
                "count" => User::count(),
                "label" => 'Total Users',
                "icon" => "users",
                "card_classes" => "has-background-primary-light",
                "link" => self::$link."/users/"
            ],
            [
                "count" => User::where('is_active',1)->count(),
                "label" => 'Active Users',
                "icon" => "user-check",
                "card_classes" => "has-background-warning-lighter",
                "link" => self::$link."/users/?status=01"
            ],
            [
                "count" => User::whereDate('last_login_at', \Carbon::today())->count(),
                "label" => 'Today Login',
                "icon" => "user-edit",
                "card_classes" => "has-background-warning-light"
            ],
            [
                "count" => Role::count(),
                "label" => 'Total Roles',
                "icon" => "user-tag",
                "card_classes" => "has-background-danger-light",
                "link" => self::$link."/roles/"
            ],
            [
                "count" => User::whereHas('roles', function ($query)
                {
                    $query->where('slug', 'administrator');
                    $query->where('vh_user_roles.is_active', 1);
                })->count(),
                "label" => 'Total Admins',
                "icon" => "users-cog",
                "card_classes" => "has-background-warning-light",
                "link" => self::$link."/users/?roles=administrator"
            ],
            [
                "count" => Job::count(),
                "label" => 'Total Jobs',
                "icon" => "briefcase",
                "card_classes" => "has-background-danger-light",
                "link" => self::$link."/advanced/jobs"
            ],
            [
                "count" => FailedJob::count(),
                "label" => 'Failed Jobs',
                "icon" => "file-medical-alt",
                "card_classes" => "has-background-primary-light",
                "link" => self::$link."/advanced/jobs-failed"
            ]
        ];

        if(vh_file_exist(str_replace("\\", "/", storage_path('logs').'\\laravel-'.\Carbon::now()->format('Y-m-d').'.log'))){
            $data[] = [
                "count" => 'Log',
                "icon" => "clipboard-list",
                "card_classes" => "has-background-warning-light",
                "has_title" => false,
                "link" => self::$link."/advanced/logs/details/laravel-".\Carbon::now()->format('Y-m-d').'.log'
            ];
        }*/

        $response['status'] = 'success';
        $response['data'] = $data;

        return $response;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
