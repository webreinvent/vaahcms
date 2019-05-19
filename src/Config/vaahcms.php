<?php

/*
 * Your package config would go here
 */

$settings =  [
    'app_name' => 'VaahCMS',
    'app_slug' => 'vaahcms',
    'admin_theme' => 'default',
    'public_theme' => 'default',
    'modules_path' => 'vaahcms/Modules',
    'plugins_path' => 'vaahcms/Plugins',
    'per_page' => 20,
    'minified' => 0,
    'api_route' => 'https://cms.vaah.dev/api/modules',
    'debug' => 1,
];

return $settings;