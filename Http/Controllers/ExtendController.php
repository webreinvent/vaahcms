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
use WebReinvent\VaahCms\Entities\Setting;
use WebReinvent\VaahCms\Entities\Theme;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Http\Controllers\Advanced\LogsController;
use WebReinvent\VaahCms\Libraries\VaahStr;

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
                'link' => self::$link."/profile/",
                'label'=> 'Profile'
            ],
            [
                'link' => route('vh.backend.logout'),
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
                'to' => self::$link,
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
                'to' => '#',
                'icon' => 'pi-user',
                'label'=> 'Users & Access',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-registrations-section'))
        {
            $list[1]['items'][] =  [
                'to' => self::$link."/registrations/",
                'icon' => 'pi-user-plus',
                'label'=> 'Registration',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-users-section'))
        {
            $list[1]['items'][] =  [
                'to' => self::$link."/users/",
                'icon' => 'pi-users',
                'label'=> 'Users',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-roles-section'))
        {
            $list[1]['items'][] =  [
                'to' => self::$link."/roles/",
                'icon' => 'pi-tag',
                'label'=> 'Roles',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[1]['items'][] =  [
                'to' =>  self::$link."/permissions/",
                'icon' => 'pi-key',
                'label'=> 'Permissions',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-module-section') ||
            \Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[2] = [
                'to' => "#",
                'icon' => "pi-box",
                'label'=> 'Extend',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-module-section'))
        {
            $list[2]['items'][] =  [
                'to' => self::$link."/modules/",
                'icon' => 'pi-box',
                'label'=> 'Modules',
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[2]['items'][] =  [
                'to' => self::$link."/themes/",
                'icon' => 'pi-palette',
                'label'=> 'Themes',
            ];
        }


        if(\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $list[3] = [
                'to' => '#',
                'icon'=> 'pi-cog',
                'label'=> 'Settings',
                'items' => [
                    [
                        'to' => self::$link."/settings/general",
                        'icon' => 'pi-cog',
                        'label'=> 'General',
                    ],
                    [
                        'to' => self::$link."/settings/user-settings",
                        'icon' => 'pi-user',
                        'label'=> 'User Settings',
                    ],
                    [
                        'to' => self::$link."/settings/env-variables",
                        'icon' => 'pi-code',
                        'label'=> 'Env Variables',
                    ],
                    [
                        'to' => self::$link."/settings/localization",
                        'icon' => 'pi-language',
                        'label'=> 'Localization',
                    ],
                    [
                        'to' => self::$link."/settings/notifications",
                        'icon' => 'pi-bell',
                        'label'=> 'Notifications',
                    ],
                    [
                        'to' => self::$link."/settings/update",
                        'icon' => 'pi-download',
                        'label'=> 'Update',
                    ],
                    [
                        'to' => self::$base."setup",
                        'icon' => 'pi-refresh',
                        'label'=> 'Reset',
                    ],
                ]
            ];
        }

        if(\Auth::user()->hasPermission('has-access-of-advanced-section'))
        {
            $list[4] = [
                'to' => self::$link."/advanced/logs",
                'icon'=> 'pi-database',
                'label'=> 'Advanced',
            ];
        }




        if(\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $list[5] = [
                'to' => '#',
                'icon'=> 'pi-images',
                'label'=> 'Manage',
                'items' => [
                    [
                        'to' => self::$link."/manage/media",
                        'icon' => 'pi-file',
                        'label'=> 'Media',
                    ],
                    [
                        'to' => self::$link."/manage/taxonomies",
                        'icon' => 'pi-sitemap',
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
                'icon' => 'redo-alt',
                'link' => self::$link."/settings/update"
            ],
            [
                'name' => 'Getting Started',
                'icon' => 'play-circle',
                'open_in_new_tab' => true,
                'link' => 'https://docs.vaah.dev/vaahcms/installation.html'
            ]
        ];


        $data['has_activated_theme'] = Theme::where('is_active',1)->exists();



        $data['next_steps'] = [
            [
                'name' => 'View your Site',
                'icon' => 'pi-desktop',
                'link' => url('/')
            ]
        ];


        $data['actions'] = [
            [
                'name' => 'Manage your Module',
                'icon' => 'pi-box',
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
