<?php

namespace WebReinvent\VaahCms\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use WebReinvent\VaahCms\Http\Controllers\Backend\Advanced\LogsController;
use WebReinvent\VaahCms\Libraries\VaahStr;
use WebReinvent\VaahCms\Models\FailedJob;
use WebReinvent\VaahCms\Models\Job;
use WebReinvent\VaahCms\Models\Permission;
use WebReinvent\VaahCms\Models\Role;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\Theme;
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
        $list = [];

        $n = 0;

        if(\Auth::user()->hasPermission('has-access-of-dashboard'))
        {
            $list[$n] = [
                'link' => self::$link,
                'icon' => 'compass',
                'label'=> 'Dashboard',
            ];

            $n++;
        }



        if(\Auth::user()->hasPermission('has-access-of-registrations-section') ||
            \Auth::user()->hasPermission('has-access-of-users-section') ||
            \Auth::user()->hasPermission('has-access-of-roles-section') ||
            \Auth::user()->hasPermission('has-access-of-permissions-section'))
        {
            $list[$n] = [
                'icon' => 'user',
                'label'=> 'Users & Access',
                'items'=> [],
            ];


            if(\Auth::user()->hasPermission('has-access-of-registrations-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/registrations/",
                    'icon' => 'user-plus',
                    'label'=> 'Registrations',
                ];
            }

            if(\Auth::user()->hasPermission('has-access-of-users-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/users/",
                    'icon' => 'users',
                    'label'=> 'Users',
                ];
            }

            if(\Auth::user()->hasPermission('has-access-of-roles-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/roles/",
                    'icon' => 'tag',
                    'label'=> 'Roles',
                ];
            }


            if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
            {
                $list[$n]['items'][] =  [
                    'link' =>  self::$link."/permissions/",
                    'icon' => 'key',
                    'label'=> 'Permissions',
                ];
            }

            $n++;
        }






        if(\Auth::user()->hasPermission('has-access-of-module-section') ||
            \Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[$n] = [
                'icon' => "pi pi-box",
                'label'=> 'Extend',
                'items'=> [],
            ];

            if(\Auth::user()->hasPermission('has-access-of-module-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/modules/",
                    'icon' => 'box',
                    'label'=> 'Modules',
                ];
            }

            if(\Auth::user()->hasPermission('has-access-of-theme-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/themes/",
                    'icon' => 'palette',
                    'label'=> 'Themes',
                ];
            }

            $n++;

        }






        if(\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $list[$n] = [
                'icon'=> 'cog',
                'label'=> 'Settings',
                'items' => [
                    [
                        'link' => self::$link."/settings/general",
                        'icon' => 'cog',
                        'label'=> 'General',
                    ],
                    [
                        'link' => self::$link."/settings/user-settings",
                        'icon' => 'user',
                        'label'=> 'User Settings',
                    ],
                    [
                        'link' => self::$link."/settings/env-variables",
                        'icon' => 'code',
                        'label'=> 'Env Variables',
                    ],
                    [
                        'link' => self::$link."/settings/localization",
                        'icon' => 'book',
                        'label'=> 'Localizations',
                    ],
                    [
                        'link' => self::$link."/settings/notifications",
                        'icon' => 'bell',
                        'label'=> 'Notifications',
                    ],
                    [
                        'link' => self::$link."/settings/update",
                        'icon' => 'download',
                        'label'=> 'Update',
                    ],
                    [
                        'link' => self::$base."setup",
                        'icon' => 'refresh',
                        'label'=> 'Reset',
                    ],
                ]
            ];

            $n++;
        }

        if (\Auth::user()->hasPermission('has-access-of-logs-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/logs",
                'icon'=> 'database',
                'label'=> 'Advanced'
            ];
            $n++;
        } else if (\Auth::user()->hasPermission('has-access-of-jobs-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/jobs",
                'icon'=> 'database',
                'label'=> 'Advanced'
            ];
            $n++;
        } else if (\Auth::user()->hasPermission('has-access-of-failedjobs-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/failedjobs",
                'icon'=> 'database',
                'label'=> 'Advanced'
            ];
            $n++;
        } else if (\Auth::user()->hasPermission('has-access-of-batches-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/batches",
                'icon'=> 'database',
                'label'=> 'Advanced'
            ];
            $n++;
        }


        if(\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $list[$n] = [
                'icon'=> 'images',
                'label'=> 'Manage',
                'items' => [
                    [
                        'link' => self::$link."/manage/media",
                        'icon' => 'file',
                        'label'=> 'Medias',
                    ],
                    [
                        'link' => self::$link."/manage/taxonomies/",
                        'icon' => 'sitemap',
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
                        'icon' => 'pi pi-envelope',
                        'link' => self::$link."/advanced/jobs/",
                    ],
                    [
                        'name' => 'Failed',
                        'count' => FailedJob::count(),
                        'type' => 'danger',
                        'icon' => 'pi pi-ban text-red-500',
                        'link' => self::$link."/advanced/failedjobs/",
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
