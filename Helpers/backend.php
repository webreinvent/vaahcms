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
    return url('/'.config('vaahcms.build_directory_name','vaahcms').'/backend/');
}
//-----------------------------------------------------------------------------------
function vh_get_backend_theme_url($theme=null)
{
    if(!$theme)
    {
        $theme = config('vaahcms.backend_theme');
    }

    $path = ('/'.config('vaahcms.build_directory_name','vaahcms').'/backend/'.$theme);
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
/**
 * UT-114 — a *build* stamp for the admin's static assets.
 *
 * The `?v=` parameter is the **package version**, and it only changes when the
 * package is released. A rebuilt admin bundle — a UI fix, a new build, a
 * rebuilt stylesheet — is therefore served under exactly the same URL as the
 * one before it, and every browser that has the old CSS/JS cached keeps
 * serving the old file. The dashboard's notice fix and the list toolbars'
 * fix were both invisible in the browser until the cache was cleared by
 * hand; that is not a workflow, it is a delivery bug.
 *
 * The stamp is the mtime of the **published** asset
 * (`public/<build dir>/backend/<theme>/<file>`), which changes on every
 * rebuild, so a new bundle is always fetched. When the file is not published
 * the stamp falls back to `0` and the URL keeps its previous shape.
 */
function vh_get_backend_asset_stamp($file_path, $theme=null)
{
    static $stamps = [];

    if(!$theme) {
        $theme = config('vaahcms.backend_theme', 'vaahtwo');
    }

    $key = $theme.'/'.$file_path;
    if(isset($stamps[$key])) {
        return $stamps[$key];
    }

    $dir = config('vaahcms.build_directory_name', 'vaahcms');
    $path = public_path($dir.'/backend/'.$theme.'/'.$file_path);

    $stamps[$key] = (is_file($path)) ? (string) filemtime($path) : '0';

    return $stamps[$key];
}
//-----------------------------------------------------------------------------------
function vh_get_backend_assets($file_path, $theme=null)
{
    return vh_get_backend_theme_url($theme)."/".$file_path
        ."?v=".config('vaahcms.version')
        ."&b=".vh_get_backend_asset_stamp($file_path, $theme);
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
function vh_get_permission_denied_json_response($permission_slugs){
    $response = vh_get_permission_denied_response($permission_slugs);
    return response()->json($response);
}
//-----------------------------------------------------------------------------------
function vh_get_permission_denied_response($permission_slugs){
    $response = [];
    $response['success'] = false;

    $response['errors'][] = trans("vaahcms-general.permission_denied");
    if(env('APP_DEBUG')){
        $response['hint'][] = 'You don\'t have "'.$permission_slugs.'" permission.';
    }
    return $response;
}
//-----------------------------------------------------------------------------------
