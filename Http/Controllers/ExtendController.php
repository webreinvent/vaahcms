<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Entities\FailedJob;
use WebReinvent\VaahCms\Entities\Job;
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Http\Controllers\Advanced\LogsController;
use WebReinvent\VaahCms\Libraries\VaahStr;
use WebReinvent\VaahCms\Models\Permission;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\User;

class ExtendController extends Controller
{

    public static $base;
    public static $link;

    //----------------------------------------------------------
    public function __construct()
    {
        $base_url = route('vh.backend')."#/";
        $vue_prefix = "vaah";
        $link = $base_url.$vue_prefix;

        self::$base = $base_url;
        self::$link = $link;
    }

    //----------------------------------------------------------

    public static function topLeftMenu()
    {




        $response['success'] = true;
        $response['data'] = [];

        return $response;
    }

    //----------------------------------------------------------
    public static function topRightUserMenu()
    {
        $list = [
            [
                'url' => self::$link."/profile/",
                'label'=> 'Profile'
            ],
            [
                'url' => route('vh.backend.logout'),
                'label'=> 'Logout'
            ],

        ];

        $response['success'] = true;
        $response['data'] = $list;

        return $response;
    }
    //----------------------------------------------------------
    public static function sidebarMenu()
    {


        if(\Auth::user()->hasPermission('has-access-of-dashboard'))
        {
            $list[0] = [
                'url' => self::$link,
                'icon' => 'pi pi-compass',
                'label'=> 'Dashboard',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-registrations-section') ||
            \Auth::user()->hasPermission('has-access-of-users-section') ||
            \Auth::user()->hasPermission('has-access-of-roles-section') ||
            \Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1] = [
                'icon' => 'pi pi-user',
                'label'=> 'Users & Access',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-registrations-section'))
        {
            $list[1]['items'][] =  [
                'url' => self::$link."/registrations/",
                'icon' => 'pi pi-user-plus',
                'label'=> 'Registration',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $list[1]['items'][] =  [
                'url' => self::$link."/users/",
                'icon' => 'pi pi-users',
                'label'=> 'Users',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $list[1]['items'][] =  [
                'url' => self::$link."/roles/",
                'icon' => 'pi pi-tag',
                'label'=> 'Roles',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1]['items'][] =  [
                'url' =>  self::$link."/permissions/",
                'icon' => 'pi pi-key',
                'label'=> 'Permissions',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-module-section') ||
            \Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[2] = [
                'icon' => "pi pi-box",
                'label'=> 'Extend',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-module-section'))
        {
            $list[2]['items'][] =  [
                'url' => self::$link."/modules/",
                'icon' => 'pi pi-box',
                'label'=> 'Modules',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[2]['items'][] =  [
                'url' => self::$link."/themes/",
                'icon' => 'pi pi-palette',
                'label'=> 'Themes',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $list[3] = [
                'icon'=> 'pi pi-cog',
                'label'=> 'Settings',
                'items' => [
                    [
                        'url' => self::$link."/settings/general",
                        'icon' => 'pi pi-cog',
                        'label'=> 'General',
                    ],
                    [
                        'url' => self::$link."/settings/user-settings",
                        'icon' => 'pi pi-user',
                        'label'=> 'User Settings',
                    ],
                    [
                        'url' => self::$link."/settings/env-variables",
                        'icon' => 'pi pi-code',
                        'label'=> 'Env Variables',
                    ],
                    [
                        'url' => self::$link."/settings/localization",
                        'icon' => 'pi pi-book',
                        'label'=> 'Localization',
                    ],
                    [
                        'url' => self::$link."/settings/notifications",
                        'icon' => 'pi pi-bell',
                        'label'=> 'Notifications',
                    ],
                    [
                        'url' => self::$link."/settings/update",
                        'icon' => 'pi pi-download',
                        'label'=> 'Update',
                    ],
                    [
                        'url' => self::$base."setup",
                        'icon' => 'pi pi-refresh',
                        'label'=> 'Reset',
                    ],
                ]
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $list[4] = [
                'url' => self::$link."/advanced/logs",
                'icon'=> 'pi pi-database',
                'label'=> 'Advanced',
            ];
        }




        if(\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $list[5] = [
                'icon'=> 'pi pi-images',
                'label'=> 'Manage',
                'items' => [
                    [
                        'url' => self::$link."/manage/media",
                        'icon' => 'pi pi-file',
                        'label'=> 'Media',
                    ],
                    [
                        'url' => self::$link."/manage/taxonomies",
                        'icon' => 'pi pi-sitemap',
                        'label'=> 'Taxonomies',
                    ]
                ]
            ];
        }



        $response['success'] = true;
        $response['data'] = $list;

        return $response;
    }
    //----------------------------------------------------------
    public function getNotificationVariables()
    {

        $response['success'] = true;
        $response['data'] = vh_notification_variables();

        return $response;
    }
    //----------------------------------------------------------
    public function getNotificationActions()
    {

        $response['success'] = true;
        $response['data'] = vh_notification_actions();

        return $response;
    }
    //----------------------------------------------------------
    public function translateDynamicStrings($params)
    {
        $string = VaahStr::translateDynamicStrings($params);

        $response['success'] = true;
        $response['data'] = $string;

        return $response;

    }
    //----------------------------------------------------------
    public function getPublicUrls()
    {

        $response['success'] = true;
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
                    "icon" => "pi-users",
                    "type" => "info",
                    "link" => self::$link."/users/"
                ],
                [
                    "count" => Role::count(),
                    "label" => 'Total Role',
                    "icon" => "pi-tags",
                    "type" => "info",
                    "link" => self::$link."/roles/"
                ],
                [
                    "count" => Permission::count(),
                    "label" => 'Total Permission',
                    "icon" => "pi-key",
                    "type" => "info",
                    "link" => self::$link."/permissions/"
                ],
                [
                    "count" => User::where('is_active',1)->count(),
                    "label" => 'Active Users',
                    "icon" => "pi-user",
                    "type" => "success",
                    "link" => self::$link."/users?status=active"
                ]
            ]

        ];


        $log_list = [];


        if(Auth::check()){
            $logs = new LogsController();

            $log_list = $logs->getList(new Request());

            if(isset($log_list->original) && $log_list->original['success']){
                $log_list = $log_list->original['data']['list'];
            }
        }

        $is_job_enabled = false;

        $queue_Setting = Setting::where('key','laravel_queues')->first();

        if($queue_Setting && $queue_Setting->value == 1){
            $is_job_enabled = true;
        }


        $data['expanded_item'] = [
            [
                'title' => 'Jobs',
                'type' => 'content',
                'description' => 'Tasks that is kept in the queue to be performed one after another.
                Queues allow you to defer the processing of a time consuming task,
                such as sending an e-mail, until a later time which drastically
                speeds up web requests to your application.',
                'is_job_enabled' => $is_job_enabled,
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
                'empty_response_note' => "No Error Log Found",
            ]
        ];


        $data['expanded_header_links'] = [
            [
                'name' => 'Check Updates',
                'icon' => 'pi pi-refresh',
                'link' => self::$link."/settings/update"
            ],
            [
                'name' => 'Getting Started',
                'icon' => 'pi pi-play',
                'open_in_new_tab' => true,
                'link' => 'https://docs.vaah.dev/vaahcms/installation.html'
            ]
        ];


        $data['has_activated_theme'] = Theme::where('is_active',1)->exists();



        $data['next_steps'] = [
            [
                'name' => 'View your Site',
                'icon' => 'pi pi-desktop',
                'link' => url('/')
            ]
        ];


        $data['actions'] = [
            [
                'name' => 'Manage your Module',
                'icon' => 'pi pi-box',
                'link' => self::$link."/modules"
            ]
        ];

        $response['success'] = true;
        $response['data'] = $data;

        return $response;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
