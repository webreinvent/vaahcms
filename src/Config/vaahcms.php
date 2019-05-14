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
    'admin_theme' => 'default',
    'public_theme' => 'default',
    'modules_path' => 'vaahcms/Modules',
    'plugins_path' => 'vaahcms/Plugins',
    'per_page' => 20,
    'minified' => 0,
];

$config = array_merge($config, $settings);

return $config;