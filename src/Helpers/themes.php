<?php

function vh_get_themes_root_path()
{
    return config('vaahcms.themes_path');
}
//-----------------------------------------------------------------------------------
function vh_get_theme_path($name)
{
    return vh_get_theme_root_path()."\/".$name;
}
//-----------------------------------------------------------------------------------
function vh_get_all_themes_paths()
{
    $list = [];
    foreach (\File::directories(vh_get_themes_root_path()) as $item)
    {
        $list[] = $item;
    }

    return $list;

}
//-----------------------------------------------------------------------------------
function vh_get_theme_settings_from_path($path)
{
    $path_settings = $path.'\settings.json';

    if(\File::exists($path_settings))
    {
        $file = File::get($path_settings);
        $settings = json_decode($file);
        $settings = (array)$settings;
        return $settings;
    }

    return null;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_settings_from_name($name)
{
    $path = vh_get_theme_path($name);

    $path_settings = $path.'\settings.json';

    if(\File::exists($path_settings))
    {
        $file = File::get($path_settings);
        $settings = json_decode($file);
        $settings = (array)$settings;
        return $settings;
    }

    return null;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_setting_value($settings, $key)
{
    if(!isset($settings[$key]))
    {
        return null;
    }

    return $settings[$key];
}
//-----------------------------------------------------------------------------------
function vh_get_active_theme_namespace()
{
    $theme = \WebReinvent\VaahCms\Entities\Theme::whereNotNull('is_active')->first();
    if($theme)
    {
        return $theme->slug."::";
    } else
    {
        return 'default::';
    }
}
//-----------------------------------------------------------------------------------