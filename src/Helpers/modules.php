<?php


//-----------------------------------------------------------------------------------
function vh_get_modules_root_path()
{
    return config('vaahcms.modules_path');
}
//-----------------------------------------------------------------------------------
function vh_get_module_path($module_name)
{
    return vh_get_modules_root_path()."\/".$module_name;
}
//-----------------------------------------------------------------------------------
function vh_get_all_modules_paths()
{
    $found_modules = [];
    foreach (\File::directories(vh_get_modules_root_path()) as $module)
    {
        $found_modules[] = $module;
    }

    return $found_modules;

}
//-----------------------------------------------------------------------------------
function vh_get_module_settings_from_path($plugin_path)
{
    $path_settings = $plugin_path.'\settings.json';

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
function vh_get_module_settings_from_name($plugin_name)
{
    $path = vh_get_module_path($plugin_name);

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
function vh_get_module_setting_value($settings, $key)
{
    if(!isset($settings[$key]))
    {
        return null;
    }

    return $settings[$key];
}
//-----------------------------------------------------------------------------------
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