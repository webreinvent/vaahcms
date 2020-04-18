<?php


//-----------------------------------------------------------------------------------
function vh_get_modules_root_path()
{
    return config('vaahcms.modules_path');
}
//-----------------------------------------------------------------------------------
function vh_get_module_path($module_name)
{
    return vh_get_modules_root_path()."/".$module_name;
}
//-----------------------------------------------------------------------------------
function vh_get_all_modules_paths()
{

    $found_modules = [];

    $modules_path = vh_get_modules_root_path();

    foreach (\File::directories($modules_path) as $module)
    {
        $found_modules[] = $module;
    }

    return $found_modules;

}
//-----------------------------------------------------------------------------------
function vh_get_all_modules_names()
{
    $list = vh_get_all_modules_paths();

    $names = null;

    if(count($list)>0)
    {
        foreach ($list as $item)
        {
            $names[] = basename($item);
        }
    }

    return $names;
}
//-----------------------------------------------------------------------------------
function vh_get_module_settings_from_path($plugin_path)
{
    $path_settings = $plugin_path.'/settings.json';

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
function vh_get_module_settings_from_name($module_name)
{
    $path = vh_get_module_path($module_name);

    $path_settings = $path.'/settings.json';

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
function vh_module_assets_url($name, $file_path)
{
    $slug = \Str::slug($name);
    $version = config($slug.'.version');
    $url = url("vaahcms/modules/".$slug."/assets/".$file_path)."?v=".$version;
    return $url;
}
//-----------------------------------------------------------------------------------
function vh_module_service_provider_name($module_name)
{
    $provider = "VaahCms\Modules\\".$module_name."\\Providers\\".$module_name."ServiceProvider";
    return $provider;
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
