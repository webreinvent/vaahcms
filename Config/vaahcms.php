<?php

/*
 * Your package config would go here
 */

$settings =  [
    'app_name' => 'VaahCMS',
    'app_slug' => 'vaahcms',
    'version' => '1.2.0',
    'get_config_version' => false,
    'website' => 'https://vaah.dev/cms',
    'documentation' => 'https://vaah.dev/cms/docs',
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
