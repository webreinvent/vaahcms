<?php

//-------------------------------------------------------------
use WebReinvent\VaahCms\Models\Module;
use WebReinvent\VaahCms\Models\Theme;

function vh_action_response($class_namespace, $method, $params=null) {
    try{
        $c = new $class_namespace($params);
        $response = $c->$method($params);
        return $response;
    } catch (\Exception $e) {
        $response['success'] = false;
        $response['errors'][] = $e->getMessage();
        return $response;
    }
}
//-------------------------------------------------------------
function vh_vaahcms_action($method, $params=null)
{
    $namespace = '\WebReinvent\VaahCms\Http\Controllers\ExtendController';
    $response = vh_action_response($namespace, $method, $params);
    return $response;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
function vh_module_action($module_name, $action, $params=null, $section='backend'){

    $namespace = '\VaahCms\Modules\\'.$module_name;

    if($section=='backend')
    {
        $namespace .= '\Http\Controllers\Backend\\';
    } else{
        $namespace .= '\Http\Controllers\Frontend\\';
    }

    $action = explode('@', $action);

    $namespace .= $action[0];
    $method = $action[1];

    return vh_action_response($namespace, $method, $params);


}
//-------------------------------------------------------------
function vh_modules_action($method, $params=null, $output_type=null)
{

    $active_modules = Module::getActiveModules();


    if(count($active_modules) < 1)
    {
        return [];
    }

    $output['success'] = [];
    $output['failed'] = [];

    foreach ($active_modules as $item)
    {

        $res = vh_module_action($item->name, 'ExtendController@'.$method);


        if(isset($res['success']) && !$res['success'])
        {
            $output['failed'][$item->slug] = $res;

        } elseif(isset($res['success']) && $res['success']
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {

            if($output_type == 'array'){

                if(isset($output['success']['data'])){
                    $output['success']['data'] = array_merge($output['success']['data'], $res['data']);
                }else{
                    $output['success']['data'] = $res['data'];
                }


            }else if($output_type == 'string'){
                $output['success']['data'] = $res['data'];
            }else if($output_type == 'concatenate_string'){
                $output['success']['data'] .= $res['data'];
            }
            else
            {
                $output['success'][$item->slug] = $res['data'];
            }
        }
    }

    return $output;

}

//-------------------------------------------------------------
function vh_theme_action($theme_name, $action, $params=null, $section='backend'){

    $namespace = '\VaahCms\Themes\\'.$theme_name;

    if($section=='backend')
    {
        $namespace .= '\Http\Controllers\Backend\\';
    } else{
        $namespace .= '\Http\Controllers\Frontend\\';
    }

    $action = explode('@', $action);

    $namespace .= $action[0];
    $method = $action[1];

    return vh_action_response($namespace, $method, $params);
}
//-------------------------------------------------------------

//-------------------------------------------------------------
function vh_themes_action($method, $params=null, $output_type=null)
{

    $themes = Theme::getActiveThemes();

    if(count($themes) < 1)
    {
        return [];
    }


    $output['success'] = [];
    $output['failed'] = [];

    foreach ($themes as $item)
    {
        $res = vh_theme_action($item->name, 'ExtendController@'.$method, $params);



        if(isset($res['success']) && !$res['success'])
        {
            $output['failed'][$item->slug] = $res;

        } elseif(isset($res['success']) && $res['success']
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {
            if($output_type == 'array'){
                $output['success']['data'][] = $res['data'];
            }else if($output_type == 'string'){
                $output['success']['data'] = $res['data'];
            }else if($output_type == 'concatenate_string'){
                $output['success']['data'] .= $res['data'];
            }
            else
            {
                $output['success'][$item->slug] = $res['data'];
            }
        }
    }

    return $output;

}
//-------------------------------------------------------------
function vh_action($method, $params=null, $output_type=null){

    $output['success'] = [];
    $output['failed'] = [];

    switch($output_type)
    {
        case 'array':


            $vaahcms_res = vh_vaahcms_action($method, $params);

            if(isset($vaahcms_res['success']) && !$vaahcms_res['success'])
            {
                $output['failed'] = $vaahcms_res;
            } else{
                $output['success'] = $vaahcms_res['data'];
            }

            $modules = vh_modules_action($method, $params, $output_type);

            if(isset($modules['success']) && count($modules['success']) > 0)
            {
                $output['success'] = array_merge($output['success'], $modules['success']['data']);
            }


            $themes = vh_themes_action($method, $params, $output_type);

            if(isset($themes['success']) &&  count($themes['success']) > 0)
            {
                $output['success'] = array_merge($output['success'], $themes['success']);
            }



            break;

        case 'string':

            $response = vh_vaahcms_action($method, $params);


            if(isset($response['success']) && $response['success'])
            {
                $params['string'] = $response['data'];
            }

            $response = vh_modules_action($method, $params, $output_type);

            if(isset($response['success']) && isset($response['data']))
            {
                $params['string'] = $response['data'];
            }

            $response = vh_themes_action($method, $output, $output_type);

            if(isset($response['success'])  && isset($response['data']))
            {
                $params['string'] = $response['data'];
            }

            $output = $params['string'];


            break;

        case 'concatenate_string':

            $output = vh_vaahcms_action($method, $params);
            $output .= vh_modules_action($method, $output, $output_type);
            $output .= vh_themes_action($method, $output, $output_type);

            break;

        default:
            $vaahcms_res = vh_vaahcms_action($method, $params);

            if(isset($vaahcms_res['success']) && !$vaahcms_res['success'])
            {
                $vaahcms['failed'] = $vaahcms_res;
            } else{
                $vaahcms['success']['vaahcms'] = $vaahcms_res['data'];
            }

            $modules = vh_modules_action($method, $params, $output_type);
            $themes = vh_themes_action($method, $params, $output_type);

            $output = array_replace_recursive($vaahcms, $modules);
            $output = array_replace_recursive($output, $themes);

            break;
    }

    return $output;
}
//-------------------------------------------------------------
/*
 * $params = array('user_id', 'string');
 */
function vh_translate_dynamic_strings($string, $params=[])
{
    $params['string'] = $string;
    $output = vh_action('translateDynamicStrings', $params, 'string' );
    return $output;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
