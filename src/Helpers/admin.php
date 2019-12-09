<?php


//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
function vh_get_admin_theme()
{
    return 'vaahcms::admin.'.config('vaahcms.admin_theme');
}
//-----------------------------------------------------------------------------------
function vh_get_assets_base_url()
{
    return \URL::asset("/");
}
//-----------------------------------------------------------------------------------
function vh_get_admin_assets_url()
{
    return \URL::asset('/vendor/vaahcms/admin/');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_theme_url()
{

    $path = ('/vendor/vaahcms/admin/'.config('vaahcms.admin_theme'));
    $url = \URL::asset($path);
    return $url;
}
//-----------------------------------------------------------------------------------
function vh_get_admin_assets_json_file()
{
    $path = vh_get_admin_theme_url()."/assets.json";

    return $path;

}
//-----------------------------------------------------------------------------------
function vh_parse_admin_assets_json_file()
{
    $assets_json_path = vh_get_admin_assets_json_file();
    $json = json_decode(file_get_contents($assets_json_path), true);
    return $json;
}
//-----------------------------------------------------------------------------------
function vh_load_admin_css()
{

    $html = "";
    $assets_array = vh_parse_admin_assets_json_file();

    if(isset($assets_array['css']) && count($assets_array['css']) > 0)
    {
        foreach($assets_array['css'] as $css)
        {
            $html .= '<link href="'.asset(vh_get_admin_asset_url($css)).'" rel="stylesheet" media="screen">'."\n";
        }
    }

    return $html;

}
//-----------------------------------------------------------------------------------
function vh_load_admin_js()
{

    $html = "";
    $assets_array = vh_parse_admin_assets_json_file();

    if(isset($assets_array['js']) && count($assets_array['js']) > 0)
    {
        foreach($assets_array['js'] as $js)
        {
            $html .= '<script src="'.asset(vh_get_admin_asset_url($js)).'"></script>'."\n";
        }
    }

    return $html;

}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
function vh_get_admin_assets($file_path)
{
    return vh_get_admin_theme_url()."/".$file_path."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_asset_url($asset_url)
{
    return $asset_url."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
function vh_get_admin_file($file_path)
{
    return vh_get_admin_theme_url()."/".$file_path;
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
