<?php


//-----------------------------------------------------------------------------------
function vh_get_plugin_root_path()
{
    return base_path('Plugins');
}
//-----------------------------------------------------------------------------------
function vh_get_plugin_path($plugin_name)
{
    return vh_get_plugin_root_path()."\/".$plugin_name;
}
//-----------------------------------------------------------------------------------
function vh_get_plugins_paths()
{
    $found_plugins = [];
    foreach (\File::directories(vh_get_plugin_root_path()) as $plugin)
    {
        $found_plugins[] = $plugin;
    }

    return $found_plugins;

}
//-----------------------------------------------------------------------------------
function vh_get_plugin_settings_from_path($plugin_path)
{
    $path_settings = $plugin_path.'\settings.json';

    if(\File::exists($path_settings))
    {
        $file = File::get($path_settings);
        $plugin_settings = json_decode($file);
        $plugin_settings = (array)$plugin_settings;
        return $plugin_settings;
    }

    return null;
}
//-----------------------------------------------------------------------------------
function vh_get_plugin_settings_from_name($plugin_name)
{
    $path = vh_get_plugin_path($plugin_name);

    $path_settings = $path.'\settings.json';

    if(\File::exists($path_settings))
    {
        $file = File::get($path_settings);
        $plugin_settings = json_decode($file);
        $plugin_settings = (array)$plugin_settings;
        return $plugin_settings;
    }

    return null;
}
//-----------------------------------------------------------------------------------
function vh_get_plugin_setting_value($settings, $key)
{
    if(!isset($settings[$key]))
    {
        return null;
    }

    return $settings[$key];
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
function vh_get_plugin_extended_views($view_file)
{
    $plugins = vh_get_plugins_paths();

    if(count($plugins) < 1)
    {
        return null;
    }

    foreach ($plugins as $plugin)
    {

        //TODO::order by settings

        $settings = vh_get_plugin_settings_from_path($plugin);


        $alias = vh_get_plugin_setting_value($settings, 'alias');

        $full_view_name = "plugin#".$alias.'::backend.extend.' . $view_file;

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