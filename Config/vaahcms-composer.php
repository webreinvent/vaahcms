<?php

/*
 * Your package config would go here
 */

$config = array();

$path = __DIR__."/../../composer.json";
if (\File::exists($path)) {
    $file = \File::get($path);
    $config = json_decode($file);
    $config = (array)$config;
}

return $config;