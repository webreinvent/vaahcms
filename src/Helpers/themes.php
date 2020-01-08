<?php


function vh_get_themes_root_path()
{
    return config('vaahcms.themes_path');
}
//-----------------------------------------------------------------------------------
function vh_get_theme_path($name)
{
    return vh_get_themes_root_path()."/".$name;
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
function vh_get_theme_settings_from_name($name)
{
    $path = vh_get_theme_path($name);

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
function vh_get_theme_view_path($name)
{
    $theme_path = vh_get_theme_path($name)."/Resources/views";

    return $theme_path;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_from_slug($theme_slug=null)
{
    if(is_null($theme_slug))
    {
        $theme = \WebReinvent\VaahCms\Entities\Theme::whereNotNull('is_active')->first();
    } else{
        $theme = \WebReinvent\VaahCms\Entities\Theme::where('slug', $theme_slug)->first();
    }

    return $theme;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_id($theme_slug=null)
{
    $theme = vh_get_theme_from_slug($theme_slug);
    return $theme->id;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_slug($theme_slug=null)
{
    $theme = vh_get_theme_from_slug($theme_slug);
    return $theme->slug;
}
//-----------------------------------------------------------------------------------
function vh_theme_assets_url($name, $file_path)
{
    $slug = \Str::slug($name);
    $version = config($slug.'.version');
    $url = url("vaahcms/themes/".$slug."/assets/".$file_path)."?v=".$version;
    return $url;
}
//-----------------------------------------------------------------------------------
function vh_get_page_templates_path($theme_slug=null)
{

    $theme = vh_get_theme_from_slug($theme_slug);

    $path = vh_get_theme_view_path($theme->name)."/page-templates";

    $list = vh_get_all_files($path);

    $result = [];

    foreach ($list as $item)
    {
        $result[] = $path."/".$item;
    }


    return $result;

}
//-----------------------------------------------------------------------------------
function vh_get_page_templates($theme_slug=null)
{
    if(is_null($theme_slug))
    {
        $theme = \WebReinvent\VaahCms\Entities\Theme::whereNotNull('is_active')->first();
    } else{
        $theme = \WebReinvent\VaahCms\Entities\Theme::where('slug', $theme_slug)->first();
    }

    $path = vh_get_theme_view_path($theme->name)."/page-templates";

    $list = vh_get_all_files($path);

    return $list;

}
//-----------------------------------------------------------------------------------
/*
 * Values of inputs can be following
$inputs = [



]
 *
 */
function vh_field($name, $type, $is_repeatable = false)
{
    $inputs = [
        'name' => $name,
        'type' => $type,
        'is_repeatable' => $is_repeatable
    ];

    $content = \WebReinvent\VaahCms\Entities\ThemeTemplate::syncTemplateFieldsViaViewRendering($inputs);
    return $content;
}
//-----------------------------------------------------------------------------------
function vh_location($location_slug, $html=false, $type='bootstrap')
{

    $data = \WebReinvent\VaahCms\Entities\ThemeLocation::getLocationData($location_slug, $html, $type);
    return $data;
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
