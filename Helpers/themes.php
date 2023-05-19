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
    $path_settings = $path.'/Config/config.php';

    $config = require $path_settings;

    if($config)
    {
        return $config;
    }

    return null;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_settings_from_name($name)
{
    $path = vh_get_theme_path($name);

    $path_settings = $path.'/Config/config.php';

    $config = require $path_settings;

    if($config)
    {
        return $config;
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
    $theme = \WebReinvent\VaahCms\Models\Theme::whereNotNull('is_active')->first();
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
function vh_get_vaahcms_theme()
{
    $theme = new stdClass();
    $theme->name = "VaahCms";
    $theme->title = "VaahCms Default Theme";
    $theme->slug = "vaahcms";
    $theme->thumbnail = "https://placehold.jp/300x160.png";
    $theme->excerpt = "VaahCms Default Theme";
    $theme->description = "VaahCms Default Theme";
    $theme->download_link = null;
    $theme->author_name = "Vaah";
    $theme->author_website = "https://vaah.dev";
    $theme->vaah_url = "";
    $theme->version = "1.0.0";
    $theme->version_number = "1";
    $theme->db_table_prefix = null;
    $theme->is_migratable = null;
    $theme->is_sample_data_available = null;
    $theme->is_update_available = null;
    $theme->is_assets_published = null;
    $theme->update_checked_at = null;
    $theme->is_active = true;
    $theme->created_at = null;
    $theme->updated_at = null;
    $theme->deleted_at = null;

    return $theme;
}
//-----------------------------------------------------------------------------------
function vh_get_theme_from_slug($theme_slug=null)
{

    if(!$theme_slug){
        $theme = \WebReinvent\VaahCms\Models\Theme::whereNotNull('is_active')
            ->whereNotNull('is_default')
            ->first();
    }else{
        $theme = \WebReinvent\VaahCms\Models\Theme::where('slug',$theme_slug)
            ->first();
    }

    if(!$theme)
    {
        return vh_get_vaahcms_theme();
    }

    return $theme;
}
//-----------------------------------------------------------------------------------
function vh_get_default_theme_slug($theme_slug=null)
{

    if(!$theme_slug)
    {
        $theme_slug = config('vaahcms.frontend_theme');
    }

    if(!$theme_slug)
    {
        $theme_slug = config('vaahcms.backend_theme');
    }

    if(!\WebReinvent\VaahExtend\Libraries\VaahDB::isConnected())
    {
        return $theme_slug;
    }

    if(!\WebReinvent\VaahExtend\Libraries\VaahDB::isTableExist('vh_themes'))
    {
        return $theme_slug;
    }

    $db_theme = \WebReinvent\VaahCms\Entities\Theme::whereNotNull('is_active')
        ->whereNotNull('is_default')
        ->first();

    if(!$db_theme)
    {
        return $theme_slug;
    }

    return $db_theme->slug;
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
function vh_theme_image_url()
{
    $slug = vh_get_theme_slug();

    $url = url("vaahcms/themes/".$slug."/assets/");

    return $url;
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
        $theme = \WebReinvent\VaahCms\Models\Theme::whereNotNull('is_active')->first();
    } else{
        $theme = \WebReinvent\VaahCms\Models\Theme::where('slug', $theme_slug)->first();
    }

    $path = vh_get_theme_view_path($theme->name)."/page-templates";

    $list = vh_get_all_files($path);

    return $list;

}
//-----------------------------------------------------------------------------------
function vh_block($block_slug = null)
{

    if(!class_exists('\VaahCms\Modules\Cms\Entities\Block')){
        return false;
    }

    $data = \VaahCms\Modules\Cms\Entities\Block::getBlock($block_slug);

    return $data;
}
//-----------------------------------------------------------------------------------
function vh_location_blocks($location_slug = null)
{

    $data = \WebReinvent\VaahCms\Models\ThemeLocation::getLocationData(
        $location_slug,
        'true',
    null,'block');

    return $data;
}
//-----------------------------------------------------------------------------------
function vh_location($location_slug, $html=false, $type='bulma')
{

    $data = \WebReinvent\VaahCms\Models\ThemeLocation::getLocationData($location_slug, $html, $type,
        'menu');


    return $data;
}
//-----------------------------------------------------------------------------------
function vh_theme_migrations_path($theme_name)
{
    $path =config('vaahcms.themes_path')."/".$theme_name."/Database/Migrations/";
    $path = str_replace(base_path()."/", "", $path);
    return $path;
}
//-----------------------------------------------------------------------------------
function vh_theme_database_seeder($module_name)
{
    return config('vaahcms.root_folder')."\Themes\\{$module_name}\\Database\Seeds\DatabaseTableSeeder";
}
//-----------------------------------------------------------------------------------
function vh_theme_namespace($module_name)
{
    $namespace = "VaahCms\Themes\\".$module_name;
    return $namespace;
}
//-----------------------------------------------------------------------------------
function vh_theme_service_provider_name($module_name)
{
    $provider = "VaahCms\Themes\\".$module_name."\\Providers\\".$module_name."ServiceProvider";
    return $provider;
}
//-----------------------------------------------------------------------------------
function vh_get_content()
{

}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
