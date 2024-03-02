<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use VaahCms\Modules\Cms\Entities\Page;
use WebReinvent\VaahCms\Models\Notified;
use WebReinvent\VaahCms\Models\Setting;
use WebReinvent\VaahCms\Models\User;

class JsonController extends Controller
{



    //----------------------------------------------------------
    public function __construct()
    {

    }

    //----------------------------------------------------------
    public function getPublicAssets(Request $request)
    {
        $manager = app('impersonate');

        $data['is_impersonating'] =  $manager->isImpersonating();
        $data['is_logo_compressed_with_sidebar'] =  (bool)config('settings.global.is_logo_compressed');

        $data['timezone'] = config('app.timezone');

        $v_version = config('vaahcms.version');

        if(env('VAAHCMS_VERSION')){
            $v_version = env('VAAHCMS_VERSION');
        }

        $data['versions'] = [
            'laravel_version' => Application::VERSION,
            'php_version' => PHP_VERSION,
            'vaahcms_version' => $v_version
        ];

        $data['vaahcms'] = [
            'name' => config('vaahcms.app_name'),
            'slug' => config('vaahcms.app_slug'),
            'version' => $v_version,
            'website' => config('vaahcms.website'),
            'docs' => config('vaahcms.documentation'),
        ];

        $data['settings'] = [
            'is_mail_settings_not_set' => $this->isMailSettingsNotSet(),
            'max_attempts_of_login' => config('settings.global.maximum_number_of_login_attempts_per_session'),
            'is_signup_page_visible' => config('settings.global.signup_page_visibility')== 1 ? true : false,
            'max_attempts_of_forgot_password' => config('settings.global.maximum_number_of_forgot_password_attempts_per_session'),
        ];

        $data['server'] = [
            'host' => $request->getHost(),
            'current_year' => \Carbon::now()->format('Y'),
            'current_date' => \Carbon::now()->format('Y-m-d'),
            'current_time' => \Carbon::now()->format('H:i:s'),
            'current_date_time' => \Carbon::now()->format('Y-m-d H:i:s'),
            'http' => 'http://',
        ];


        if(\Request::secure())
        {
            $data['server']['http'] = 'https://';
        }

        //-----Vue Errors----------------------
        /*
         * To Set Errors:
         * session(['vue_errors'=>$response['messages']]);
         */
        $data['vue_errors'] = null;
        $vue_errors = session()->get('vue_errors');
        if(isset($vue_errors) && count($vue_errors) > 0)
        {
            $data['vue_errors'] = $vue_errors;
        }
        \Session::forget('vue_errors');
        //-----Vue Errors----------------------

        //-----Vue Messages----------------------
        /*
         * To Set messages:
         * session(['vue_messages'=>$response['messages']]);
         */
        $data['vue_messages'] = null;
        $vue_messages = session()->get('vue_messages');
        if(isset($vue_messages) && count($vue_messages) > 0)
        {
            $data['vue_messages'] = $vue_messages;
        }
        \Session::forget('vue_messages');
        //-----/Vue Messages----------------------


        if(\Auth::check())
        {
            $data['auth_user'] = [
                'name' => \Auth::user()->name,
                'email' => \Auth::user()->email,
                'avatar' => \Auth::user()->avatar,
            ];

            //-----Vue Backend Notices----------------------
            $data['vue_notices'] = Notified::viaBackend();
            //-----/Vue Backend Notices----------------------

            $data['extended_views'] = $this->getExtendedViews();

            $data['language_string']['dashboard'] = [
                "greeting" => trans("vaahcms-dashboard.welcome_to_vaahcms"),
                'message' => trans("vaahcms-dashboard.welcome_message"),
                'get_started' => trans("vaahcms-dashboard.get_started"),
                'next_steps' => trans("vaahcms-dashboard.next_steps"),
                'more_actions' => trans("vaahcms-dashboard.more_actions"),
                'go_to_theme' => trans("vaahcms-dashboard.go_to_theme"),
                'activate_theme' => trans("vaahcms-dashboard.activate_theme"),
                'or' => trans("vaahcms-dashboard.or"),
                'create_your_own_theme' => trans("vaahcms-dashboard.create_your_own_theme"),
            ];

        }
        $data['language_strings'] = [];
        //---------------------------------------------------
        $data['language_strings']['general'] = $this->getGeneralStrings();
        //---------------------------------------------------
        $data['language_strings']['advanced_layout'] = $this->getAdvancedLayoutStrings();
        //---------------------------------------------------
        $data['language_strings']['settings_layout'] = $this->getSettingsLayoutStrings();
        //---------------------------------------------------
        $data['language_strings']['crud_actions'] = $this->getCrudActionStrings();
        //---------------------------------------------------
        $data['language_strings']['update'] = $this->getUpdateVaahCmsStrings();
        //---------------------------------------------------

        $data['urls']['public'] = config('settings.global.backend_homepage_link');
        $data['urls']['theme'] = vh_get_backend_theme_url();
        $data['urls']['image'] = vh_get_backend_theme_image_url();
        $data['urls']['upload'] = route('vh.backend.media.upload');
        $data['urls']['dashboard'] = route('vh.backend')."#/vaah";


        $data['backend_logo_url'] = vh_backend_logo();


        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);


    }
    //----------------------------------------------------------
    public function isLoggedIn(Request $request)
    {


        $data = [];

        $is_logged = false;

        if(\Auth::check())
        {
            $is_logged = true;

            $user = auth()->user();

            if($user->security_code)
            {

                if($user->security_code_expired_at &&
                    $user->security_code_expired_at->lt(now()))
                {
                    $is_logged = false;

                }elseif(config('settings.global.mfa_status') !== 'disable'){


                    if(config('settings.global.mfa_status') == 'all-users'){

                        $is_logged = false;

                    }elseif(config('settings.global.mfa_status') == 'user-will-have-option'
                        && is_array($user->mfa_methods) && count($user->mfa_methods) >= 0){

                        $is_logged = false;

                    }

                }

            }
        }

        $response['success'] = true;
        $response['data']['is_logged_in'] = $is_logged;

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function isMailSettingsNotSet()
    {

        $mail_username = env('MAIL_USERNAME');
        $mail_password = env('MAIL_PASSWORD');
        //$mail_from_name = env('MAIL_FROM_NAME');
        //$mail_from_email = env('MAIL_FROM_ADDRESS');

        if(
            isset($mail_username) && !empty($mail_username)
            && isset($mail_password) && !empty($mail_password)
            //&& isset($mail_from_name) && !empty($mail_from_name)
            //&& isset($mail_from_email) && !empty($mail_from_email)
        )
        {
            return false;
        }


        return true;

    }
    //----------------------------------------------------------

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissions(Request $request)
    {


        $data = [];

        if(!\Auth::check())
        {
            $response['success'] = false;
            $response['errors'] = ["You're not logged in."];
            return response()->json($response);
        }

        $response['success'] = true;
        $response['data']['list'] = \Auth::user()->permissions(true);

        return response()->json($response);

    }
    //----------------------------------------------------------
    public function getExtendedViews()
    {

        $locations = [
            'sidebar_menu'=>'sidebarMenu',
            'top_left_menu'=>'topLeftMenu',
            'top_right_user_menu'=>'topRightUserMenu',
        ];

        $views = [];
        foreach ($locations as $location=>$method)
        {
            $views[$location] = vh_action($method);
        }


        return $views;
    }
    //----------------------------------------------------------
    public function getUsers(Request $request, $query=null)
    {

        $list = User::where(function($q) use ($query){
            $q->where('first_name', 'LIKE', '%'.$query.'%')
                ->orWhere('last_name', 'LIKE', '%'.$query.'%')
                ->orWhere('email', 'LIKE', '%'.$query.'%')
                ->orWhere('phone', 'LIKE', '%'.$query.'%');
        })->select('id', 'first_name', 'middle_name',
            'last_name', 'display_name', 'email')
            ->take(10)
            ->orderBy('created_at', 'desc')->get();

        return $list;

    }
    //----------------------------------------------------------
    public function getCrudActionStrings() : array {

        return  [
            "create_button" => trans("vaahcms-crud-action.create_button"),
            "form_text_create" => trans("vaahcms-crud-action.form_text_create"),
            "placeholder_search" => trans("vaahcms-crud-action.placeholder_search"),
            "filters_button" => trans("vaahcms-crud-action.filters_button"),
            "reset_button" => trans("vaahcms-crud-action.reset_button"),
            "bulk_activate" => trans("vaahcms-crud-action.bulk_activate"),
            "bulk_deactivate" => trans("vaahcms-crud-action.bulk_deactivate"),
            "mark_all_as_active" => trans("vaahcms-crud-action.mark_all_as_active"),
            "mark_all_as_inactive" => trans("vaahcms-crud-action.mark_all_as_inactive"),
            "bulk_trash" => trans("vaahcms-crud-action.bulk_trash"),
            "trash_all" => trans("vaahcms-crud-action.trash_all"),
            "bulk_restore" => trans("vaahcms-crud-action.bulk_restore"),
            "restore_all" => trans("vaahcms-crud-action.restore_all"),
            "bulk_delete" => trans("vaahcms-crud-action.bulk_delete"),
            "delete_all" => trans("vaahcms-crud-action.delete_all"),
            "filter_sort_by" => trans("vaahcms-crud-action.filter_sort_by"),
            "sort_by_none" => trans("vaahcms-crud-action.sort_by_none"),
            "sort_by_updated_ascending" => trans("vaahcms-crud-action.sort_by_updated_ascending"),
            "sort_by_updated_descending" => trans("vaahcms-crud-action.sort_by_updated_descending"),
            "filter_trashed" => trans("vaahcms-crud-action.filter_trashed"),
            "filter_exclude_trashed" => trans("vaahcms-crud-action.filter_exclude_trashed"),
            "filter_include_trashed" => trans("vaahcms-crud-action.filter_include_trashed"),
            "filter_only_trashed" => trans("vaahcms-crud-action.filter_only_trashed"),
            "filter_status" => trans("vaahcms-crud-action.filter_status"),
            "filter_is_active" => trans("vaahcms-crud-action.filter_is_active"),
            "filter_is_active_all" => trans("vaahcms-crud-action.filter_is_active_all"),
            "filter_only_active" => trans("vaahcms-crud-action.filter_only_active"),
            "filter_only_inactive" => trans("vaahcms-crud-action.filter_only_inactive"),
            "edit_button" => trans("vaahcms-crud-action.edit_button"),
            "save_button" => trans("vaahcms-crud-action.save_button"),
            "toolkit_text_update" => trans("vaahcms-crud-action.toolkit_text_update"),
            "toolkit_text_view" => trans("vaahcms-crud-action.toolkit_text_view"),
            "toolkit_text_trash" => trans("vaahcms-crud-action.toolkit_text_trash"),
            "toolkit_text_restore" => trans("vaahcms-crud-action.toolkit_text_restore"),
            "toolkit_text_edit" => trans("vaahcms-crud-action.toolkit_text_edit"),
            "toolkit_text_copy_slug" => trans("vaahcms-crud-action.toolkit_text_copy_slug"),
            "form_save_and_close" => trans("vaahcms-crud-action.form_save_and_close"),
            "form_save_and_clone" => trans("vaahcms-crud-action.form_save_and_clone"),
            "form_save_and_new" => trans("vaahcms-crud-action.form_save_and_new"),
            "form_create_and_new" => trans("vaahcms-crud-action.form_create_and_new"),
            "form_create_and_close" => trans("vaahcms-crud-action.form_create_and_close"),
            "form_create_and_clone" => trans("vaahcms-crud-action.form_create_and_clone"),
            "form_fill" => trans("vaahcms-crud-action.form_fill"),
            "form_add_custom_field" => trans("vaahcms-crud-action.form_add_custom_field"),
            "form_text_deleted" => trans("vaahcms-crud-action.form_text_deleted"),
            "form_trash" => trans("vaahcms-crud-action.form_trash"),
            "form_delete" => trans("vaahcms-crud-action.form_delete"),
            "form_reset" => trans("vaahcms-crud-action.form_reset"),
            "form_text_restore" => trans("vaahcms-crud-action.form_text_restore"),
            "view_edit" => trans("vaahcms-crud-action.view_edit"),
            "view_trash" => trans("vaahcms-crud-action.view_trash"),
            "view_delete" => trans("vaahcms-crud-action.view_delete"),
            "view_deleted" => trans("vaahcms-crud-action.view_deleted"),
            "view_restore" => trans("vaahcms-crud-action.view_restore"),
        ];
    }
    //----------------------------------------------------------
    public function getGeneralStrings() :array {
        return [
            "select_an_action_type" => trans("vaahcms-general.select_an_action_type"),
            "select_records" => trans("vaahcms-general.select_records"),
            "select_a_record" => trans("vaahcms-general.select_a_record"),
        ];
    }
    public function getUpdateVaahCmsStrings() :array {
        return [
            "check_for_update_button" => trans("vaahcms-update-setting.check_for_update_button"),
            "check_for_update_message" => trans("vaahcms-update-setting.check_for_update_message"),
            "new_updates" => trans("vaahcms-update-setting.new_updates"),
            "a_newer_version" => trans("vaahcms-update-setting.a_newer_version"),
            "of_vaahcms_is_available" => trans("vaahcms-update-setting.of_vaahcms_is_available"),
            "new_updates_message" => trans("vaahcms-update-setting.new_updates_message"),
            "downloading_latest_version" => trans("vaahcms-update-setting.downloading_latest_version"),
            "reload_button" => trans("vaahcms-update-setting.reload_button"),
            "major_release_message" => trans("vaahcms-update-setting.major_release_message"),
            "steps_of_manually_upgrade" => trans("vaahcms-update-setting.steps_of_manually_upgrade"),
            "go_to_root_path" => trans("vaahcms-update-setting.go_to_root_path"),
            "current_version_of_vaahcms_is" => trans("vaahcms-update-setting.current_version_of_vaahcms_is"),
            "verify_version_in_composer_json" => trans("vaahcms-update-setting.verify_version_in_composer_json"),
            "run_composer_update" => trans("vaahcms-update-setting.run_composer_update"),
            "run_migrations_and_seeds" => trans("vaahcms-update-setting.run_migrations_and_seeds"),
            "update_publish_assets" => trans("vaahcms-update-setting.update_publish_assets"),
            "clear_cache_button" => trans("vaahcms-general-setting.clear_cache_button"),
            "heading_update_vaahcms" => trans("vaahcms-update-setting.heading_update_vaahcms"),
        ];
    }
    //----------------------------------------------------------

    public function getAdvancedLayoutStrings() :array {
        return [
            "advanced" => trans("vaahcms-sidebar-menu.advanced"),
            "logs" => trans("vaahcms-sidebar-menu.logs"),
            "failed_jobs" => trans("vaahcms-sidebar-menu.failed_jobs_title"),
            "jobs" => trans("vaahcms-dashboard.jobs"),
            "batches" => trans("vaahcms-sidebar-menu.batches"),
        ];
    }
    //----------------------------------------------------------
    public function getSettingsLayoutStrings() :array {
        return [
            "settings" => trans("vaahcms-sidebar-menu.settings"),
            "general" => trans("vaahcms-sidebar-menu.general"),
            "user_settings" => trans("vaahcms-sidebar-menu.user_settings"),
            "env_variables" => trans("vaahcms-sidebar-menu.env_variables"),
            "localizations" => trans("vaahcms-sidebar-menu.localizations"),
            "notifications" => trans("vaahcms-sidebar-menu.notifications"),
            "update" => trans("vaahcms-sidebar-menu.update"),
            "reset" => trans("vaahcms-sidebar-menu.reset"),
        ];
    }
    //----------------------------------------------------------
    //----------------------------------------------------------


}
