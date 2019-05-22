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



//-----------------------------------------------------------------------------------
function vh_get_modules_extended_views($view_file)
{

    $modules = vh_get_all_modules_paths();


    if(count($modules) < 1)
    {
        return null;
    }

    $list = [];

    foreach ($modules as $module)
    {

        $settings = vh_get_module_settings_from_path($module);

        if(isset($settings['extend']->menu->order))
        {
            $list[$settings['extend']->menu->order] = $settings;
        }

    }

    ksort($list);

    foreach ($list as $module_settings)
    {
        $slug = vh_get_module_setting_value($module_settings, 'slug');

        $full_view_name = $slug.'::admin.extend.' . $view_file;

        if (\View::exists($full_view_name)) {

            try {
                $view = \View::make($full_view_name);

                echo $view;
            } catch (\Exception $e) {
                echo json_encode($e->getMessage());
            }
        }
    }

}
//-----------------------------------------------------------------------------------