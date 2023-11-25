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

        }


        //---------------------------------------------
        $data['language_string']['registrations'] = [
            "registrations_title" => trans("vaahcms-registration.registrations_title"),
            "filter_email_verification_pending" => trans("vaahcms-registration.filter_email_verification_pending"),
            "filter_email_verified" => trans("vaahcms-registration.filter_email_verified"),
            "filter_user_created" => trans("vaahcms-registration.filter_user_created"),
            "table_gender_male" => trans("vaahcms-registration.table_gender_male"),
            "table_gender_female" => trans("vaahcms-registration.table_gender_female"),
            "table_gender_others" => trans("vaahcms-registration.table_gender_others"),
        ];
        //-------------------------------------------------
        $data['language_string']['users'] = [
            "users" => trans("vaahcms-common-fields.users"),
        ];
        //--------------------------------------------------
        $data['language_string']['roles' ] = [
            "roles" => trans("vaahcms-common-fields.roles"),
        ];
        //---------------------------------------------------
        $data['language_string']['roles' ] = [
            "permissions" => trans("vaahcms-common-fields.permissions"),
        ];
        //---------------------------------------------------

        $data['language_string']['crud_actions'] = [
            "create_button" => trans("vaahcms-crud-action.create_button"),
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
            "bulk_delete" => trans("vaahcms-crud-action.delete"),
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
            "form_save_and_close" => trans("vaahcms-crud-action.form_save_and_close"),
            "form_save_and_clone" => trans("vaahcms-crud-action.form_save_and_clone"),
            "form_save_and_new" => trans("vaahcms-crud-action.form_save_and_new"),
            "form_create_and_new" => trans("vaahcms-crud-action.form_create_and_new"),
            "form_create_and_close" => trans("vaahcms-crud-action.form_create_and_close"),
            "form_create_and_clone" => trans("vaahcms-crud-action.form_create_and_clone"),
            "form_fill" => trans("vaahcms-crud-action.form_fill"),
            "form_text_deleted" => trans("vaahcms-crud-action.form_text_deleted"),
            "form_trash" => trans("vaahcms-crud-action.form_trash"),
            "form_delete" => trans("vaahcms-crud-action.form_delete"),
            "form_text_restore" => trans("vaahcms-crud-action.form_text_restore"),
        ];


        $data['language_string']['common_fields'] = [
            "registrations" => trans("vaahcms-common-fields.registrations"),
            "create" => trans("vaahcms-common-fields.create"),
            "search" => trans("vaahcms-common-fields.search"),
            "filters" => trans("vaahcms-common-fields.filters"),
            "reset" => trans("vaahcms-common-fields.reset"),
            "activate" => trans("vaahcms-common-fields.activate"),
            "deactivate" => trans("vaahcms-common-fields.deactivate"),
            "mark_all_as_active" => trans("vaahcms-common-fields.mark_all_as_active"),
            "mark_all_as_inactive" => trans("vaahcms-common-fields.mark_all_as_inactive"),
            "trash" => trans("vaahcms-common-fields.trash"),
            "trash_all" => trans("vaahcms-common-fields.trash_all"),
            "restore" => trans("vaahcms-common-fields.restore"),
            "restore_all" => trans("vaahcms-common-fields.restore_all"),
            "delete" => trans("vaahcms-common-fields.delete"),
            "delete_all" => trans("vaahcms-common-fields.delete_all"),
            "sort_by" => trans("vaahcms-common-fields.sort_by"),
            "none" => trans("vaahcms-common-fields.none"),
            "updated_ascending" => trans("vaahcms-common-fields.updated_ascending"),
            "updated_descending" => trans("vaahcms-common-fields.updated_descending"),
            "trashed" => trans("vaahcms-common-fields.trashed"),
            "exclude_trashed" => trans("vaahcms-common-fields.exclude_trashed"),
            "include_trashed" => trans("vaahcms-common-fields.include_trashed"),
            "only_trashed" => trans("vaahcms-common-fields.only_trashed"),
            "status" => trans("vaahcms-common-fields.status"),
            "email_verification_pending" => trans("vaahcms-common-fields.email_verification_pending"),
            "email_verified" => trans("vaahcms-common-fields.email_verified"),
            "user_created" => trans("vaahcms-common-fields.user_created"),
            "users" => trans("vaahcms-common-fields.users"),
            "is_active" => trans("vaahcms-common-fields.is_active"),
            "all" => trans("vaahcms-common-fields.all"),
            "only_active" => trans("vaahcms-common-fields.only_active"),
            "only_inactive" => trans("vaahcms-common-fields.only_inactive"),
            "roles" => trans("vaahcms-common-fields.roles"),
            "permissions" => trans("vaahcms-common-fields.permissions"),
            "view" => trans("vaahcms-common-fields.view"),
            "update" => trans("vaahcms-common-fields.update"),
            "edit" => trans("vaahcms-common-fields.edit"),
            "save" => trans("vaahcms-common-fields.save"),
            "save_and_close" => trans("vaahcms-common-fields.save_and_close"),
            "save_and_clone" => trans("vaahcms-common-fields.save_and_clone"),
            "save_and_new" => trans("vaahcms-common-fields.save_and_new"),
            "create_and_new" => trans("vaahcms-common-fields.create_and_new"),
            "create_and_close" => trans("vaahcms-common-fields.create_and_close"),
            "create_and_clone" => trans("vaahcms-common-fields.create_and_clone"),
            "fill" => trans("vaahcms-common-fields.fill"),
            "deleted" => trans("vaahcms-common-fields.deleted"),
            "male" => trans("vaahcms-common-fields.male"),
            "female" => trans("vaahcms-common-fields.female"),
            "others" => trans("vaahcms-common-fields.others"),
            "generate_new_api_token" => trans("vaahcms-common-fields.generate_new_api_token"),
            "active_all_roles" => trans("vaahcms-common-fields.active_all_roles"),
            "inactive_all_roles" => trans("vaahcms-common-fields.inactive_all_roles"),
            "yes" => trans("vaahcms-common-fields.yes"),
            "no" => trans("vaahcms-common-fields.no"),
            "copy_slug" => trans("vaahcms-common-fields.copy_slug"),
            "impersonate" => trans("vaahcms-common-fields.impersonate"),
            "view_permissions" => trans("vaahcms-common-fields.view_permissions"),
            "view_users" => trans("vaahcms-common-fields.view_users"),
            "active_all_permissions" => trans("vaahcms-common-fields.active_all_permissions"),
            "inactive_all_permissions" => trans("vaahcms-common-fields.inactive_all_permissions"),
            "attach_to_all_users" => trans("vaahcms-common-fields.attach_to_all_users"),
            "detach_to_all_users" => trans("vaahcms-common-fields.detach_to_all_users"),
            "active" => trans("vaahcms-common-fields.active"),
            "inactive" => trans("vaahcms-common-fields.inactive"),
            "select_a_module" => trans("vaahcms-common-fields.select_a_module"),
            "select_a_section" => trans("vaahcms-common-fields.select_a_section"),
            "view_role" => trans("vaahcms-common-fields.view_role"),
            "user" => trans("vaahcms-common-fields.user")

        ];

        $data['language_string']['settings'] = [
            "general_settings" => trans("vaahcms-settings.general_settings"),
            "expand_all" => trans("vaahcms-settings.expand_all"),
            "collapse_all" => trans("vaahcms-settings.collapse_all"),
            "site_settings" => trans("vaahcms-settings.site_settings"),
            "site_settings_message" => trans("vaahcms-settings.site_settings_message"),
            "site_title" => trans("vaahcms-settings.site_title"),
            "copyright_text" => trans("vaahcms-settings.copyright_text"),
            "use_app_name" => trans("vaahcms-settings.use_app_name"),
            "custom" => trans("vaahcms-settings.custom"),
            "enter_custom_text" => trans("vaahcms-settings.enter_custom_text"),
            "default_site_language" => trans("vaahcms-settings.default_site_language"),
            "redirect_after_frontend_login" => trans("vaahcms-settings.redirect_after_frontend_login"),
            "use_app_url" => trans("vaahcms-settings.use_app_url"),
            "enter_custom_url" => trans("vaahcms-settings.enter_custom_url"),
            "meta_description" => trans("vaahcms-settings.meta_description"),
            "copyright_year" => trans("vaahcms-settings.copyright_year"),
            "use_current_year" => trans("vaahcms-settings.use_current_year"),
            "search_engine_visibility" => trans("vaahcms-settings.search_engine_visibility"),
            "enable" => trans("vaahcms-settings.enable"),
            "disable" => trans("vaahcms-settings.disable"),
            "max_password_attempts" => trans("vaahcms-settings.max_password_attempts"),
            "allowed_file_types_for_upload" => trans("vaahcms-settings.allowed_file_types_for_upload"),

        ];

        $data['language_string']['sidebar_menu'] = [
            "general" => trans("vaahcms-sidebar-menu.general"),
            "user_settings" => trans("vaahcms-sidebar-menu.user_settings"),
            "env_variables" => trans("vaahcms-sidebar-menu.env_variables"),
            "localizations" => trans("vaahcms-sidebar-menu.localizations"),
            "notifications" => trans("vaahcms-sidebar-menu.notifications"),
            "update" => trans("vaahcms-sidebar-menu.update"),
            "reset" => trans("vaahcms-sidebar-menu.reset"),
        ];


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

        $data['urls']['public'] = url("/");
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
            'top_right_menu'=>'topRightMenu',
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

    //----------------------------------------------------------

    //----------------------------------------------------------
    //----------------------------------------------------------
    //----------------------------------------------------------


}
