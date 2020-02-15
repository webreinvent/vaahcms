<?php

/*
 * Your package config would go here
 */

$settings =  [
    'app_name' => 'VaahCms',
    'app_slug' => 'vaahcms',
    'admin_theme' => 'default',
    'public_theme' => 'default',
    'public_theme_template' => 'default',
    'root_folder' => 'VaahCms',
    'root_folder_path' => base_path().'/VaahCms',
    'modules_path' => base_path().'/VaahCms/Modules',
    'themes_path' => base_path().'/VaahCms/Themes',
    'plugins_path' => base_path().'/VaahCms/Plugins',
    'per_page' => 20,
    'minified' => 0,
    'api_route' => 'https://cms.vaah.dev/api',
    'debug' => 1,
    'uploads' => [
        'allowed_extensions' => ["jpg", "jpeg", 'png', "gif", "csv"]
    ]
];

return $settings;
