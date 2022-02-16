<?php

/*
 * Your package config would go here
 */

$settings =  [
    'app_name' => 'VaahCMS',
    'app_slug' => 'vaahcms',
    'version' => '1.6.12',
    'get_config_version' => false,
    'website' => 'https://vaah.dev/cms',
    'documentation' => 'https://docs.vaah.dev/vaahcms',
    'backend_theme' => 'vaahone',
    'frontend_theme' => 'vaahone',
    'frontend_theme_template' => 'vaahone',
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
    'per_page' => 20,
    'minified' => 0,
    'api_route' => 'https://api.vaah.dev/cms/',
    'debug' => 1,
    'uploads' => [
        'allowed_extensions' => ["jpg", "jpeg", 'png', "gif", "csv", "docs", "pdf"]
    ]
];


return $settings;
