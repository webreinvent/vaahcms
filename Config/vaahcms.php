<?php

/*
 * Your package config would go here
 */


$settings =  [
    'app_name' => 'VaahCMS',
    'app_slug' => 'vaahcms',
    'version' => '2.2.11',
    'php_version_required' => '8.1',
    'get_config_version' => false,
    'website' => 'https://vaah.dev/cms',
    'documentation' => 'https://docs.vaah.dev/vaahcms',
    'backend_theme' => 'vaahtwo',
    'frontend_theme' => 'vaahcms',
    'frontend_theme_template' => 'welcome',
    'root_folder' => 'VaahCms',
    'allowed_file_upload_size' => '50',
    'root_folder_path' => base_path().'/VaahCms',
    'modules_path' => base_path().'/VaahCms/Modules',
    'themes_path' => base_path().'/VaahCms/Themes',
    'plugins_path' => base_path().'/VaahCms/Plugins',
    'modules_url' => env('APP_URL').'/vaahcms/modules',
    'themes_url' => env('APP_URL').'/vaahcms/themes',
    'storage_url' => env('APP_URL').'/storage',
    'public_url' => env('APP_URL'),
    'backend_logo_url' => 'vaahcms/backend/vaahone/images/vaahcms-logo.svg', // vh_backend_logo()
    'per_page' => 20,
    'build_directory_name' => 'vaahcms',    //config('vaahcms.build_directory_name')
    'minified' => 0,
    'api_route' => 'https://api.vaah.dev/cms/v2/',
    'debug' => 1,
    'uploads' => [
        'allowed_extensions' => ["jpg", "jpeg", 'png', "gif", "csv", "docs", "pdf"]
    ],
    'css' => [
        // you can use relative or absolute url
    ],
    'js' => [
        // you can use relative or absolute url
    ]
];
return $settings;
