<?php

/*
 * Your package config would go here
 */

$config = array();

$path = __DIR__."/../../composer.json";
if (File::exists($path)) {
    $file = File::get($path);
    $config = json_decode($file);
    $config = (array)$config;
}
$settings =  [
    'app_name' => 'VaahCMS',
    'app_slug' => 'vaahcms',
    'admin_theme' => 'default',
    'public_theme' => 'default',
    'modules_path' => 'vaahcms/Modules',
    'plugins_path' => 'vaahcms/Plugins',
    'per_page' => 20,
    'minified' => 1,
    'show_console_logs' => 1,
];

$config = array_merge($config, $settings);

return $config;