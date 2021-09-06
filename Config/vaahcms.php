<?php

/*
 * Your package config would go here
 */

$settings =  [
    'app_name' => env('APP_NAME'),
    'app_version' => env('APP_VERSION'),
    'app_url' => env('APP_URL'),
    'get_config_version' => false,
    'cms' => 'VaahCMS',
    'cms_version' => '1.2.5',
    'website' => 'https://vaah.dev/cms',
    'documentation' => 'https://docs.vaah.dev/vaahcms/',
    'backend_theme' => 'vaahone',
    'frontend_theme' => 'vaahone',
    'frontend_theme_template' => 'vaahone',
    'root_folder' => 'VaahCms',
    'allowed_file_upload_size' => '50',
    'root_folder_path' => base_path().'/VaahCms',
    'modules_path' => base_path().'/VaahCms/Modules',
    'themes_path' => base_path().'/VaahCms/Themes',
    'plugins_path' => base_path().'/VaahCms/Plugins',
    'per_page' => 20,
    'minified' => 0,
    'api_route' => 'https://api.vaah.dev/cms/',
    'debug' => 1,
    'uploads' => [
        'allowed_extensions' => ["jpg", "jpeg", 'png', "gif", "csv"]
    ]
];


return $settings;
