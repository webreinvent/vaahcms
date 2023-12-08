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
            "users_title" => trans("vaahcms-user.users_title"),
            "view_role_active_all_roles" => trans("vaahcms-user.view_role_active_all_roles"),
            "view_role_inactive_all_roles" => trans("vaahcms-user.view_role_inactive_all_roles"),
            "view_generate_new_api_token" => trans("vaahcms-user.view_generate_new_api_token"),
            "view_role_yes" => trans("vaahcms-user.view_role_yes"),
            "view_role_no" => trans("vaahcms-user.view_role_no"),
            "view_role_text_view" => trans("vaahcms-user.view_role_text_view"),
            "view_role_placeholder_search" => trans("vaahcms-user.view_role_placeholder_search"),
            "view_role_reset_button" => trans("vaahcms-user.view_role_reset_button"),
            "toolkit_text_impersonate" => trans("vaahcms-user.toolkit_text_impersonate"),
        ];
        //--------------------------------------------------
        $data['language_string']['roles' ] = [
            "roles_title" => trans("vaahcms-role.roles_title"),
            "toolkit_text_view_users" => trans("vaahcms-role.toolkit_text_view_users"),
            "toolkit_text_view_permissions" => trans("vaahcms-role.toolkit_text_view_permissions"),
            "view_permissions_active_all_permissions" => trans("vaahcms-role.view_permissions_active_all_permissions"),
            "view_permissions_inactive_all_permissions" => trans("vaahcms-role.view_permissions_inactive_all_permissions"),
            "view_permissions_select_a_module" => trans("vaahcms-role.view_permissions_select_a_module"),
            "view_permissions_select_a_section" => trans("vaahcms-role.view_permissions_select_a_section"),
            "view_permissions_placeholder_search" => trans("vaahcms-role.view_permissions_placeholder_search"),
            "view_users_placeholder_search" => trans("vaahcms-role.view_users_placeholder_search"),
            "view_permissions_reset_button" => trans("vaahcms-role.view_permissions_reset_button"),
            "view_users_reset_button" => trans("vaahcms-role.view_users_reset_button"),
            "view_permissions_yes" => trans("vaahcms-role.view_permissions_yes"),
            "view_users_yes" => trans("vaahcms-role.view_users_yes"),
            "view_permissions_no" => trans("vaahcms-role.view_permissions_no"),
            "view_users_no" => trans("vaahcms-role.view_users_no"),
            "view_permissions_active" => trans("vaahcms-role.view_permissions_active"),
            "view_permissions_inactive" => trans("vaahcms-role.view_permissions_inactive"),
            "view_permissions_text_view" => trans("vaahcms-role.view_permissions_text_view"),
            "view_users_text_view" => trans("vaahcms-role.view_users_text_view"),
            "view_users_attach_to_all_users" => trans("vaahcms-role.view_users_attach_to_all_users"),
            "view_users_detach_to_all_users" => trans("vaahcms-role.view_users_detach_to_all_users"),
        ];
        //---------------------------------------------------
        $data['language_string']['permissions' ] = [
            "permissions_title" => trans("vaahcms-permission.permissions_title"),
            "toolkit_text_view_role" => trans("vaahcms-permission.toolkit_text_view_role"),
            "toolkit_text_view_user" => trans("vaahcms-permission.toolkit_text_view_user"),
            "view_roles_placeholder_search" => trans("vaahcms-permission.view_roles_placeholder_search"),
            "view_roles_reset_button" => trans("vaahcms-permission.view_roles_reset_button"),
            "view_roles_yes" => trans("vaahcms-permission.view_roles_yes"),
            "view_roles_no" => trans("vaahcms-permission.view_roles_no"),
            "view_roles_text_view" => trans("vaahcms-permission.view_roles_text_view"),
            "view_roles_active_all_roles" => trans("vaahcms-permission.view_roles_active_all_roles"),
            "view_roles_inactive_all_roles" => trans("vaahcms-permission.view_roles_inactive_all_roles"),
        ];
        //---------------------------------------------------

        $data['language_string']['crud_actions'] = [
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


        $data['language_string']['general_settings'] = [
            "heading" => trans("vaahcms-general-setting.heading"),
            "expand_all" => trans("vaahcms-general-setting.expand_all"),
            "collapse_all" => trans("vaahcms-general-setting.collapse_all"),
            "site_settings" => trans("vaahcms-general-setting.site_settings"),
            "site_settings_message" => trans("vaahcms-general-setting.site_settings_message"),
            "site_title" => trans("vaahcms-general-setting.site_title"),
            "copyright_text" => trans("vaahcms-general-setting.copyright_text"),
            "use_app_name" => trans("vaahcms-general-setting.use_app_name"),
            "custom" => trans("vaahcms-general-setting.custom"),
            "enter_custom_text" => trans("vaahcms-general-setting.enter_custom_text"),
            "default_site_language" => trans("vaahcms-general-setting.default_site_language"),
            "redirect_after_frontend_login" => trans("vaahcms-general-setting.redirect_after_frontend_login"),
            "use_app_url" => trans("vaahcms-general-setting.use_app_url"),
            "enter_custom_link" => trans("vaahcms-general-setting.enter_custom_link"),
            "meta_description" => trans("vaahcms-general-setting.meta_description"),
            "copyright_year" => trans("vaahcms-general-setting.copyright_year"),
            "use_current_year" => trans("vaahcms-general-setting.use_current_year"),
            "search_engine_visibility" => trans("vaahcms-general-setting.search_engine_visibility"),
            "enable" => trans("vaahcms-general-setting.enable"),
            "disable" => trans("vaahcms-general-setting.disable"),
            "assign_roles_on_registration" => trans("vaahcms-general-setting.assign_roles_on_registration"),
            "max_number_of_forgot_password_attempts" => trans("vaahcms-general-setting.max_number_of_forgot_password_attempts"),
            "maximum_number_of_login_attempts" => trans("vaahcms-general-setting.maximum_number_of_login_attempts"),
            "placeholder_search" => trans("vaahcms-general-setting.placeholder_search"),
            "allowed_file_types_for_upload" => trans("vaahcms-general-setting.allowed_file_types_for_upload"),
            "password_protection" => trans("vaahcms-general-setting.password_protection"),
            "laravel_queues" => trans("vaahcms-general-setting.laravel_queues"),
            "maintenance_mode" => trans("vaahcms-general-setting.maintenance_mode"),
            "signup_page" => trans("vaahcms-general-setting.signup_page"),
            "is_logo_compressed_with_sidebar" => trans("vaahcms-general-setting.is_logo_compressed_with_sidebar"),
            "redirect_after_backend_logout" => trans("vaahcms-general-setting.redirect_after_backend_logout"),
            "backend" => trans("vaahcms-general-setting.backend"),
            "frontend" => trans("vaahcms-general-setting.frontend"),
            "enter_redirection_link" => trans("vaahcms-general-setting.enter_redirection_link"),
            "true" => trans("vaahcms-general-setting.true"),
            "false" => trans("vaahcms-general-setting.false"),
            "save_settings_button" => trans("vaahcms-general-setting.save_settings_button"),
            "clear_cache_button" => trans("vaahcms-general-setting.clear_cache_button"),

            "securities" => trans("vaahcms-general-setting.securities"),
            "securities_message" => trans("vaahcms-general-setting.securities_message"),
            "multi_factor_authentication" => trans("vaahcms-general-setting.multi_factor_authentication"),
            "multi_factor_authentication_message" => trans("vaahcms-general-setting.multi_factor_authentication_message"),
            "multi_factor_authentication_disable" => trans("vaahcms-general-setting.multi_factor_authentication_disable"),
            "enable_for_all_users" => trans("vaahcms-general-setting.enable_for_all_users"),
            "users_will_have_option_to_enable_it" => trans("vaahcms-general-setting.users_will_have_option_to_enable_it"),
            "mfa_methods" => trans("vaahcms-general-setting.mfa_methods"),
            "email_otp_verification" => trans("vaahcms-general-setting.email_otp_verification"),
            "sms_otp_verification" => trans("vaahcms-general-setting.sms_otp_verification"),
            "authenticator_app" => trans("vaahcms-general-setting.authenticator_app"),
            "mfa_switch_text" => trans("vaahcms-general-setting.mfa_switch_text"),
            "securities_save_button" => trans("vaahcms-general-setting.securities_save_button"),

            "date_and_time" => trans("vaahcms-general-setting.date_and_time"),
            "global_date_and_time_settings" => trans("vaahcms-general-setting.global_date_and_time_settings"),
            "date_format" => trans("vaahcms-general-setting.date_format"),
            "time_format" => trans("vaahcms-general-setting.time_format"),
            "date_time_format" => trans("vaahcms-general-setting.date_time_format"),
            "date_and_time_custom" => trans("vaahcms-general-setting.date_and_time_custom"),
            "date_and_time_save_button" => trans("vaahcms-general-setting.date_and_time_save_button"),

            "social_media_and_links" => trans("vaahcms-general-setting.social_media_and_links"),
            "static_links_management" => trans("vaahcms-general-setting.static_links_management"),
            "add_link" => trans("vaahcms-general-setting.add_link"),
            "social_media_links_placeholder_text_enter" => trans("vaahcms-general-setting.social_media_links_placeholder_text_enter"),
            "social_media_links_placeholder_text_link" => trans("vaahcms-general-setting.social_media_links_placeholder_text_link"),
            "add_link_button" => trans("vaahcms-general-setting.add_link_button"),
            "social_media_and_links_save_button" => trans("vaahcms-general-setting.social_media_and_links_save_button"),

            "scripts" => trans("vaahcms-general-setting.scripts"),
            "scripts_message" => trans("vaahcms-general-setting.scripts_message"),
            "after_head_tag_start" => trans("vaahcms-general-setting.after_head_tag_start"),
            "before_head_tag_close" => trans("vaahcms-general-setting.before_head_tag_close"),
            "after_body_tag_start" => trans("vaahcms-general-setting.after_body_tag_start"),
            "before_body_tag_close" => trans("vaahcms-general-setting.before_body_tag_close"),
            "scripts_save_button" => trans("vaahcms-general-setting.scripts_save_button"),

            "meta_tags" => trans("vaahcms-general-setting.meta_tags"),
            "add_meta_tags_button" => trans("vaahcms-general-setting.add_meta_tags_button"),
            "meta_tag" => trans("vaahcms-general-setting.meta_tag"),
            "global_meta_tags" => trans("vaahcms-general-setting.global_meta_tags"),
            "meta_tag_content" => trans("vaahcms-general-setting.meta_tag_content"),
            "meta_tag_select_type" => trans("vaahcms-general-setting.meta_tag_select_type"),
            "meta_tag_select_any" => trans("vaahcms-general-setting.meta_tag_select_any"),
            "meta_tag_generate_button" => trans("vaahcms-general-setting.meta_tag_generate_button"),
            "meta_tag_save_button" => trans("vaahcms-general-setting.meta_tag_save_button"),

        ];

        $data['language_string']['user_settings'] = [
            "heading" => trans("vaahcms-user-setting.heading"),
            "expand_all" => trans("vaahcms-user-setting.expand_all"),
            "collapse_all" => trans("vaahcms-user-setting.collapse_all"),
            "fields" => trans("vaahcms-user-setting.fields"),
            "field_name" => trans("vaahcms-user-setting.field_name"),
            "is_hidden" => trans("vaahcms-user-setting.is_hidden"),
            "apply_to_registration" => trans("vaahcms-user-setting.apply_to_registration"),
            "custom_field_name" => trans("vaahcms-user-setting.custom_field_name"),
            "custom_is_hidden" => trans("vaahcms-user-setting.custom_is_hidden"),
            "custom_apply_to_registration" => trans("vaahcms-user-setting.custom_apply_to_registration"),
            "custom_is_password_reveal" => trans("vaahcms-user-setting.custom_is_password_reveal"),
            "custom_min_length" => trans("vaahcms-user-setting.custom_min_length"),
            "custom_max_length" => trans("vaahcms-user-setting.custom_max_length"),
            "excerpt" => trans("vaahcms-user-setting.excerpt"),
            "custom_fields" => trans("vaahcms-user-setting.custom_fields"),
            "custom_fields_message" => trans("vaahcms-user-setting.custom_fields_message"),
            "no_records" => trans("vaahcms-user-setting.no_records"),
            "select_a_type" => trans("vaahcms-user-setting.select_a_type"),
            "custom_fields_add_button" => trans("vaahcms-user-setting.custom_fields_add_button"),
            "custom_fields_save_button" => trans("vaahcms-user-setting.custom_fields_save_button"),
        ];

        $data['language_string']['env_variables'] = [
            "heading" => trans("vaahcms-env-variable.heading"),
            "download" => trans("vaahcms-env-variable.download"),
            "refresh" => trans("vaahcms-env-variable.refresh"),
            "add_env_variable_button" => trans("vaahcms-env-variable.add_env_variable_button"),
            "save_button" => trans("vaahcms-env-variable.save_button"),
        ];

        $data['language_string']['localization_settings'] = [
            "heading" => trans("vaahcms-localization-setting.heading"),
            "add_language_button" => trans("vaahcms-localization-setting.add_language_button"),
            "add_category_button" => trans("vaahcms-localization-setting.add_category_button"),
            "localization_message" => trans("vaahcms-localization-setting.localization_message"),
            "localization_placeholder_search" => trans("vaahcms-localization-setting.localization_placeholder_search"),
            "localization_placeholder_select_a_category" => trans("vaahcms-localization-setting.localization_placeholder_select_a_category"),
            "localization_placeholder_select_a_filter" => trans("vaahcms-localization-setting.localization_placeholder_select_a_filter"),
            "localization_reset_button" => trans("vaahcms-localization-setting.localization_reset_button"),
            "add_new_languages" => trans("vaahcms-localization-setting.add_new_languages"),
            "add_new_languages_placeholder_name" => trans("vaahcms-localization-setting.add_new_languages_placeholder_name"),
            "add_new_languages_save_button" => trans("vaahcms-localization-setting.add_new_languages_save_button"),
            "add_new_category" => trans("vaahcms-localization-setting.add_new_category"),
            "add_new_category_placeholder_category_name" => trans("vaahcms-localization-setting.add_new_category_placeholder_category_name"),
            "add_new_category_save_button" => trans("vaahcms-localization-setting.add_new_category_save_button"),
            "localization_add_string_button" => trans("vaahcms-localization-setting.localization_add_string_button"),
            "localization_generate_language_files" => trans("vaahcms-localization-setting.localization_generate_language_files"),
            "localization_save_button" => trans("vaahcms-localization-setting.localization_save_button"),
            "localization_placeholder_select_a_language" => trans("vaahcms-localization-setting.localization_placeholder_select_a_language"),
            "localization_empty_value" => trans("vaahcms-localization-setting.localization_empty_value"),
            "localization_filled_value" => trans("vaahcms-localization-setting.localization_filled_value"),
            "no_language_string_exist" => trans("vaahcms-localization-setting.no_language_string_exist"),
        ];

        $data['language_string']['notification_settings'] = [
            "heading" => trans("vaahcms-notification-setting.heading"),
            "add_button" => trans("vaahcms-notification-setting.add_button"),
            "placeholder_search" => trans("vaahcms-notification-setting.placeholder_search"),
            "reset_button" => trans("vaahcms-notification-setting.reset_button"),
            "error_message" => trans("vaahcms-notification-setting.error_message"),
            "placeholder_enter_new_notification_name" => trans("vaahcms-notification-setting.placeholder_enter_new_notification_name"),
            "save_button" => trans("vaahcms-notification-setting.save_button"),
            "column_notification_title" => trans("vaahcms-notification-setting.column_notification_title"),
            "column_edit" => trans("vaahcms-notification-setting.column_edit"),
            "go_back_button" => trans("vaahcms-notification-setting.go_back_button"),
            "variables" => trans("vaahcms-notification-setting.variables"),
            "variables_placeholder_search" => trans("vaahcms-notification-setting.variables_placeholder_search"),
            "notification_options" => trans("vaahcms-notification-setting.notification_options"),
            "deliver_via" => trans("vaahcms-notification-setting.deliver_via"),
            "add_subject_button" => trans("vaahcms-notification-setting.add_subject_button"),
            "add_form_button" => trans("vaahcms-notification-setting.add_form_button"),
            "add_greetings_button" => trans("vaahcms-notification-setting.add_greetings_button"),
            "add_line_button" => trans("vaahcms-notification-setting.add_line_button"),
            "add_action_button" => trans("vaahcms-notification-setting.add_action_button"),
            "notification_save_button" => trans("vaahcms-notification-setting.notification_save_button"),
            "notification_test_button" => trans("vaahcms-notification-setting.notification_test_button"),
            "notification_test_send_button" => trans("vaahcms-notification-setting.notification_test_send_button"),
            "error_notifications" => trans("vaahcms-notification-setting.error_notifications"),
        ];

        $data['language_string']['update_settings'] = [
            "heading" => trans("vaahcms-update-setting.heading"),
            "check_for_update_button" => trans("vaahcms-update-setting.check_for_update_button"),
            "check_for_update_message" => trans("vaahcms-update-setting.check_for_update_message"),
            "current_version_of_vaahcms_is" => trans("vaahcms-update-setting.current_version_of_vaahcms_is"),
            "a_newer_version" => trans("vaahcms-update-setting.a_newer_version"),
            "of_vaahcms_is_available" => trans("vaahcms-update-setting.of_vaahcms_is_available"),
            "new_updates" => trans("vaahcms-update-setting.new_updates"),
            "new_updates_message" => trans("vaahcms-update-setting.new_updates_message"),
            "update_now_button" => trans("vaahcms-update-setting.update_now_button"),
            "downloading_latest_version" => trans("vaahcms-update-setting.downloading_latest_version"),
            "reload" => trans("vaahcms-update-setting.reload"),
            "major_release_message" => trans("vaahcms-update-setting.major_release_message"),
            "steps_of_manually_upgrade" => trans("vaahcms-update-setting.steps_of_manually_upgrade"),
        ];

        $data['language_string']['extend_modules'] = [
            "heading" => trans("vaahcms-extend-module.heading"),
            "install_button" => trans("vaahcms-extend-module.install_button"),
            "check_updates_button" => trans("vaahcms-extend-module.check_updates_button"),
            "toolkit_text_reload" => trans("vaahcms-extend-module.toolkit_text_reload"),
            "filter_button" => trans("vaahcms-extend-module.filter_button"),
            "placeholder_search" => trans("vaahcms-extend-module.placeholder_search"),
            "reset_button" => trans("vaahcms-extend-module.reset_button"),
            "filter_all" => trans("vaahcms-extend-module.filter_all"),
            "filter_active" => trans("vaahcms-extend-module.filter_active"),
            "filter_inactive" => trans("vaahcms-extend-module.filter_inactive"),
            "filter_update_available" => trans("vaahcms-extend-module.filter_update_available"),
            "name" => trans("vaahcms-extend-module.name"),
            "version" => trans("vaahcms-extend-module.version"),
            "developed_by" => trans("vaahcms-extend-module.developed_by"),
            "activate_button" => trans("vaahcms-extend-module.activate_button"),
            "deactivate_button" => trans("vaahcms-extend-module.deactivate_button"),
            "toolkit_text_activate_module" => trans("vaahcms-extend-module.toolkit_text_activate_module"),
            "toolkit_text_deactivate_module" => trans("vaahcms-extend-module.toolkit_text_deactivate_module"),
            "toolkit_text_view" => trans("vaahcms-extend-module.toolkit_text_view"),
            "toolkit_text_trash" => trans("vaahcms-extend-module.toolkit_text_trash"),
            "toolkit_text_actions" => trans("vaahcms-extend-module.toolkit_text_actions"),
            "toolkit_text_publish_assets" => trans("vaahcms-extend-module.toolkit_text_publish_assets"),
            "toolkit_text_import_sample_data" => trans("vaahcms-extend-module.toolkit_text_import_sample_data"),
            "toolkit_text_update_module" => trans("vaahcms-extend-module.toolkit_text_update_module"),
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
