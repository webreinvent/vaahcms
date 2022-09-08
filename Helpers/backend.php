<?php


//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
function vh_get_backend_theme()
{
    return 'vaahcms::backend.'.config('vaahcms.backend_theme');
}
//-----------------------------------------------------------------------------------
function vh_get_assets_base_url()
{
    return url("/");
}
//-----------------------------------------------------------------------------------
function vh_get_backend_assets_url()
{
    return url('/vaahcms/backend/');
}
//-----------------------------------------------------------------------------------
function vh_get_backend_theme_url($theme=null)
{
    if(!$theme)
    {
        $theme = config('vaahcms.backend_theme');
    }

    $path = ('/vaahcms/backend/'.$theme);
    $url = url($path);

    return $url;

}
//-----------------------------------------------------------------------------------
function vh_get_backend_theme_image_url()
{

    $path = ('/vaahcms/backend/'.config('vaahcms.backend_theme').'/images/');
    $url = url($path);

    return $url;

}
//-----------------------------------------------------------------------------------
function vh_get_backend_assets_json_file()
{
    $path = vh_get_backend_theme_url()."/assets.json";

    return $path;

}
//-----------------------------------------------------------------------------------
function vh_parse_backend_assets_json_file()
{
    $assets_json_path = vh_get_backend_assets_json_file();
    $json = json_decode(file_get_contents($assets_json_path), true);
    return $json;
}
//-----------------------------------------------------------------------------------
function vh_load_backend_css()
{

    $html = "";
    $assets_array = vh_parse_backend_assets_json_file();

    if(isset($assets_array['css']) && count($assets_array['css']) > 0)
    {
        foreach($assets_array['css'] as $css)
        {
            $html .= '<link href="'.asset(vh_get_backend_asset_url($css)).'" rel="stylesheet" media="screen">'."\n";
        }
    }

    return $html;

}
//-----------------------------------------------------------------------------------
function vh_load_backend_js()
{

    $html = "";
    $assets_array = vh_parse_backend_assets_json_file();

    if(isset($assets_array['js']) && count($assets_array['js']) > 0)
    {
        foreach($assets_array['js'] as $js)
        {
            $html .= '<script src="'.asset(vh_get_backend_asset_url($js)).'"></script>'."\n";
        }
    }

    return $html;

}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
function vh_get_backend_assets($file_path, $theme=null)
{
    return vh_get_backend_theme_url($theme)."/".$file_path."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
function vh_get_backend_asset_url($asset_url)
{
    return $asset_url."?v=".config('vaahcms.version');
}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
function vh_get_backend_file($file_path)
{
    return vh_get_backend_theme_url()."/".$file_path;
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
