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

        try{

            $response['status'] = 'success';
            $response['data'] = [];

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }

    //----------------------------------------------------------
    public static function topRightUserMenu()
    {

        try{

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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public static function sidebarMenu()
    {

        try{


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
                        [
                            'link' => self::$base."setup",
                            'icon' => 'retweet',
                            'label'=> 'Reset'
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

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public function getNotificationVariables()
    {

        try{

            $response['status'] = 'success';
            $response['data'] = vh_notification_variables();

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public function getNotificationActions()
    {

        try{

            $response['status'] = 'success';
            $response['data'] = vh_notification_actions();

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public function translateDynamicStrings($params)
    {

        try{

            $string = VaahStr::translateDynamicStrings($params);

            $response['status'] = 'success';
            $response['data'] = $string;

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;

    }
    //----------------------------------------------------------
    public function getPublicUrls()
    {
        try{

            $response['status'] = 'success';
            $response['data'] = vh_public_urls();

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    public function getDashboardItems()
    {

        try{

            $data = array();

            $data['card'] = [
                "title" => "Users and Roles",
                "list" => [
                    [
                        "count" => User::count(),
                        "label" => 'Total User',
                        "icon" => "users",
                        "type" => "info",
                        "link" => self::$link."/users/"
                    ],
                    [
                        "count" => Role::count(),
                        "label" => 'Total Role',
                        "icon" => "user-tag",
                        "type" => "info",
                        "link" => self::$link."/roles/"
                    ],
                    [
                        "count" => Permission::count(),
                        "label" => 'Total Permission',
                        "icon" => "key",
                        "type" => "info",
                        "link" => self::$link."/permissions/"
                    ],
                    [
                        "count" => User::where('is_active',1)->count(),
                        "label" => 'Active Users',
                        "icon" => "user-check",
                        "type" => "success",
                        "link" => self::$link."/users?status=active"
                    ]
                ]

            ];


            $log_list = [];


            if(Auth::check()){
                $logs = new LogsController();

                $log_list = $logs->getList(new Request());

                if(isset($log_list->original) && $log_list->original['status'] == 'success'){
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

            $response['status'] = 'success';
            $response['data'] = $data;

        }catch (\Exception $e){
            $response = [];
            $response['status'] = 'failed';
            if(env('APP_DEBUG')){
                $response['errors'][] = $e->getMessage();
                $response['hint'] = $e->getTrace();
            } else{
                $response['errors'][] = 'Something went wrong.';
            }
        }

        return $response;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
