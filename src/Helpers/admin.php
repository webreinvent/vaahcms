<?php


//-----------------------------------------------------------------------------------
function vh_get_admin_theme()
{
    return 'vaahcms::admin.'.config('vaahcms.admin_theme');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_assets_url()
{
    return asset('/resources/assets/vendor/vaahcms/admin/');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_theme_url()
{
    return asset('/resources/assets/vendor/vaahcms/admin/'.config('vaahcms.admin_theme'));
}
//-----------------------------------------------------------------------------------
function vh_get_admin_assets_json_file()
{
    $path = base_path("/resources/assets/vendor/vaahcms/admin/".config('vaahcms.admin_theme')."/assets.json");

    return $path;



}
//-----------------------------------------------------------------------------------
function vh_load_admin_css()
{
    $assets_json_path = vh_get_admin_assets_json_file();

    $json = json_decode(file_get_contents($assets_json_path), true);

    echo "<pre>";
    print_r($json);
    echo "</pre>";
    die("<hr/>line number=123");

}
//-----------------------------------------------------------------------------------
function vh_get_admin_css($file_name)
{
    return vh_get_admin_theme_url()."/css/".$file_name."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_assets($file_path)
{
    return vh_get_admin_theme_url()."/".$file_path."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_js($file_name)
{
    return vh_get_admin_theme_url()."/js/".$file_name."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
function vh_get_admin_img($file_path)
{
    return vh_get_admin_theme_url()."/img/".$file_path;
}
//-----------------------------------------------------------------------------------
function vh_get_admin_file($file_path)
{
    return vh_get_admin_theme_url()."/".$file_path;
}
//-----------------------------------------------------------------------------------