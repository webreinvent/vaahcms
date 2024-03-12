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
                'label'=> trans("vaahcms-sidebar-menu.dashboard"),
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
                'label'=> trans("vaahcms-sidebar-menu.users_access"),
                'items'=> [],
            ];


            if(\Auth::user()->hasPermission('has-access-of-registrations-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/registrations/",
                    'icon' => 'user-plus',
                    'label'=> trans("vaahcms-sidebar-menu.registrations"),
                ];
            }

            if(\Auth::user()->hasPermission('has-access-of-users-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/users/",
                    'icon' => 'users',
                    'label'=>  trans("vaahcms-sidebar-menu.users"),
                ];
            }

            if(\Auth::user()->hasPermission('has-access-of-roles-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/roles/",
                    'icon' => 'tag',
                    'label'=> trans("vaahcms-sidebar-menu.roles"),
                ];
            }


            if(\Auth::user()->hasPermission('has-access-of-permissions-section'))
            {
                $list[$n]['items'][] =  [
                    'link' =>  self::$link."/permissions/",
                    'icon' => 'key',
                    'label'=> trans("vaahcms-sidebar-menu.permissions"),
                ];
            }

            $n++;
        }






        if(\Auth::user()->hasPermission('has-access-of-module-section') ||
            \Auth::user()->hasPermission('has-access-of-theme-section'))
        {
            $list[$n] = [
                'icon' => "pi pi-box",
                'label'=> trans("vaahcms-sidebar-menu.extend"),
                'items'=> [],
            ];

            if(\Auth::user()->hasPermission('has-access-of-module-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/modules/",
                    'icon' => 'box',
                    'label'=> trans("vaahcms-sidebar-menu.modules"),
                ];
            }

            if(\Auth::user()->hasPermission('has-access-of-theme-section'))
            {
                $list[$n]['items'][] =  [
                    'link' => self::$link."/themes/",
                    'icon' => 'palette',
                    'label'=> trans("vaahcms-sidebar-menu.themes"),
                ];
            }

            $n++;

        }






        if(\Auth::user()->hasPermission('has-access-of-setting-section'))
        {
            $list[$n] = [
                'icon'=> 'cog',
                'label'=> trans("vaahcms-sidebar-menu.settings"),
                'items' => [
                    [
                        'link' => self::$link."/settings/general",
                        'icon' => 'cog',
                        'label'=> trans("vaahcms-sidebar-menu.general"),
                    ],
                    [
                        'link' => self::$link."/settings/user-settings",
                        'icon' => 'user',
                        'label'=> trans("vaahcms-sidebar-menu.user_settings"),
                    ],
                    [
                        'link' => self::$link."/settings/env-variables",
                        'icon' => 'code',
                        'label'=> trans("vaahcms-sidebar-menu.env_variables"),
                    ],
                    [
                        'link' => self::$link."/settings/localization",
                        'icon' => 'book',
                        'label'=> trans("vaahcms-sidebar-menu.localizations"),
                    ],
                    [
                        'link' => self::$link."/settings/notifications",
                        'icon' => 'bell',
                        'label'=> trans("vaahcms-sidebar-menu.notifications"),
                    ],
                    [
                        'link' => self::$link."/settings/update",
                        'icon' => 'download',
                        'label'=> trans("vaahcms-sidebar-menu.update"),
                    ],
                    [
                        'link' => self::$base."setup",
                        'icon' => 'refresh',
                        'label'=> trans("vaahcms-sidebar-menu.reset"),
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
                'label'=> trans("vaahcms-sidebar-menu.advanced")
            ];
            $n++;
        } else if (\Auth::user()->hasPermission('has-access-of-jobs-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/jobs",
                'icon'=> 'database',
                'label'=> trans("vaahcms-sidebar-menu.advanced")
            ];
            $n++;
        } else if (\Auth::user()->hasPermission('has-access-of-failedjobs-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/failedjobs",
                'icon'=> 'database',
                'label'=> trans("vaahcms-sidebar-menu.advanced")
            ];
            $n++;
        } else if (\Auth::user()->hasPermission('has-access-of-batches-section'))
        {
            $list[$n] = [
                'link' => self::$link."/advanced/batches",
                'icon'=> 'database',
                'label'=> trans("vaahcms-sidebar-menu.advanced")
            ];
            $n++;
        }


        if(\Auth::user()->hasPermission('has-access-of-media-section'))
        {
            $list[$n] = [
                'icon'=> 'images',
                'label'=> trans("vaahcms-sidebar-menu.manage"),
                'items' => [
                    [
                        'link' => self::$link."/manage/media",
                        'icon' => 'file',
                        'label'=> trans("vaahcms-sidebar-menu.medias")
                    ],
                    [
                        'link' => self::$link."/manage/taxonomies/",
                        'icon' => 'sitemap',
                        'label'=> trans("vaahcms-sidebar-menu.taxonomies"),
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
            "title" => trans("vaahcms-dashboard.users_and_roles"),
            "link_text" => trans("vaahcms-dashboard.view_details"),
            "list" => [
                [
                    "count" => User::count(),
                    "label" => trans("vaahcms-dashboard.total_user"),
                    "icon" => "pi-users",
                    "type" => "info",
                    "link" => self::$link."/users/"
                ],
                [
                    "count" => Role::count(),
                    "label" => trans("vaahcms-dashboard.total_role"),
                    "icon" => "pi-tags",
                    "type" => "info",
                    "link" => self::$link."/roles/"
                ],
                [
                    "count" => Permission::count(),
                    "label" => trans("vaahcms-dashboard.total_permission"),
                    "icon" => "pi-key",
                    "type" => "info",
                    "link" => self::$link."/permissions/"
                ],
                [
                    "count" => User::where('is_active',1)->count(),
                    "label" => trans("vaahcms-dashboard.active_users"),
                    "icon" => "pi-user",
                    "type" => "success",
                    "link" => self::$link."/users?filter[is_active]=true"
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
                'title' => trans("vaahcms-dashboard.jobs"),
                'run_jobs' => trans("vaahcms-dashboard.run_jobs"),
                'view_settings' => trans("vaahcms-dashboard.view_settings"),
                'type' => 'content',
                'description' => trans("vaahcms-dashboard.content_description"),
                'is_job_enabled' => $is_job_enabled,
                'footer' => [
                    [
                        'name' => trans("vaahcms-dashboard.pending_jobs"),
                        'count' => Job::count(),
                        'type' => 'info',
                        'icon' => 'pi pi-envelope',
                        'link' => self::$link."/advanced/jobs/",
                    ],
                    [
                        'name' => trans("vaahcms-dashboard.failed_jobs"),
                        'count' => FailedJob::count(),
                        'type' => 'danger',
                        'icon' => 'pi pi-ban text-red-500',
                        'link' => self::$link."/advanced/failedjobs/",
                    ]
                ]
            ],
            [
                'title' => trans("vaahcms-dashboard.laravel_logs"),
                'view_log' => trans("vaahcms-dashboard.view_log"),
                'type' => 'list',
                'list' => $log_list,
                'list_limit' => 5,
                'link_text' => trans("vaahcms-dashboard.view_all_recent_logs"),
                'link' => self::$link."/advanced/logs/",
                'empty_response_note' => trans("vaahcms-dashboard.no_error_log_found"),
            ]
        ];


        $data['expanded_header_links'] = [
            [
                'name' => trans("vaahcms-dashboard.check_updates"),
                'icon' => 'pi pi-refresh',
                'link' => self::$link."/settings/update"
            ],
            [
                'name' => trans("vaahcms-dashboard.getting_started"),
                'icon' => 'pi pi-play',
                'open_in_new_tab' => true,
                'link' => 'https://docs.vaah.dev/vaahcms/installation.html'
            ]
        ];


        $data['has_activated_theme'] = Theme::where('is_active',1)->exists();



        $data['next_steps'] = [
            [
                'name' => trans("vaahcms-dashboard.view_your_site"),
                'icon' => 'pi pi-desktop',
                'link' => url('/')
            ]
        ];


        $data['actions'] = [
            [
                'name' => trans("vaahcms-dashboard.manage_your_module"),
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
