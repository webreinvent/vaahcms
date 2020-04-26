<?php

//-------------------------------------------------------------
use WebReinvent\VaahCms\Entities\Module;
use WebReinvent\VaahCms\Entities\Theme;

function vh_action_response($class_namespace, $method, $params=null) {
    try{
        $c = new $class_namespace($params);
        $response = $c->$method($params);
        return $response;
    } catch (\Exception $e) {
        $response['status'] = 'failed';
        $response['errors'][] = $e->getMessage();
        return $response;
    }
}
//-------------------------------------------------------------
function vh_vaahcms_action($method, $params=null)
{

    $namespace = '\WebReinvent\VaahCms\Http\Controllers\ExtendController';

    $response = vh_action_response($namespace, $method, $params);

    if(isset($response['status']) && $response['status']=='success' && isset($response['data']))
    {
        return  $response['data'];
    }

    return [];

}
//-------------------------------------------------------------
//-------------------------------------------------------------
function vh_module_action_response($module_name, $action, $params=null, $section='backend'){

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
function vh_theme_action_response($theme_name, $action, $params=null, $section='backend'){

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
function vh_module_action($method, $params=null, $output_type=null)
{

    $active_modules = Module::getActiveModules();

    if(count($active_modules) < 1)
    {
        return [];
    }

    $output = [];

    foreach ($active_modules as $item)
    {
        $res = vh_module_action_response($item->name, 'ExtendController@'.$method);

        if($res['status'] == 'failed')
        {
            continue;
        } elseif(isset($res['status']) && $res['status'] == 'success'
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {
            if($output_type == 'array'){
                $output[] = $res['data'];
            }else if($output_type == 'string'){
                $output = $res['data'];
            }else if($output_type == 'concatenate_string'){
                $output .= $res['data'];
            }
            else
            {
                $output[$item->slug] = $res['data'];
            }
        }
    }

    return $output;

}

//-------------------------------------------------------------
function vh_theme_action($method, $params=null, $output_type=null)
{

    $output = Theme::getActiveThemes();

    if(count($output) < 1)
    {
        return [];
    }

    $output = [];

    foreach ($output as $item)
    {
        $res = vh_module_action_response($item->name, 'ExtendController@'.$method, $params);

        if($res['status'] == 'failed')
        {
            continue;
        } elseif(isset($res['status']) && $res['status'] == 'success'
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {

            if($output_type == 'array'){
                $output[] = $res['data'];
            }else if($output_type == 'string'){
                $output = $res['data'];
            }else if($output_type == 'concatenate_string'){
                $output .= $res['data'];
            }
            else
            {
                $output[$item->slug] = $res['data'];
            }
        }
    }

    return $output;

}
//-------------------------------------------------------------
function vh_action($method, $params=null, $output_type=null){

    $output = null;

    switch($output_type)
    {
        case 'array':
            $output['vaahcms'] = vh_vaahcms_action($method, $params);
            $output['modules'] = vh_module_action($method, $params, $output_type);
            $output['themes'] = vh_theme_action($method, $params, $output_type);

            $output = array_merge($output['vaahcms'], $output['modules'], $output['themes']);
            break;

        case 'string':

            $string = vh_vaahcms_action($method, $params);

            if(!empty($string) && !is_null($string))
            {
                $params['string'] = $string;
            }


            $string = vh_module_action($method, $params, $output_type);

            if(!empty($string) && !is_null($string))
            {
                $params['string'] = $string;
            }


            $string = vh_theme_action($method, $output, $output_type);

            if(!empty($string) && !is_null($string))
            {
                $params['string'] = $string;
            }

            $output = $params['string'];

            break;

        case 'concatenate_string':

            $output = vh_vaahcms_action($method, $params);
            $output .= vh_module_action($method, $output, $output_type);
            $output .= vh_theme_action($method, $output, $output_type);

            break;

        default:
            $output['vaahcms'] = vh_vaahcms_action($method, $params);
            $output['modules'] = vh_module_action($method, $params, $output_type);
            $output['themes'] = vh_theme_action($method, $params, $output_type);
            break;
    }

    return $output;
}
//-------------------------------------------------------------
/*
 * $params = array('user_id', 'string');
 */
function vh_translate_dynamic_strings($params)
{
    $output = vh_action('translateDynamicStrings', $params, 'string' );

    echo "<pre>";
    print_r($output);
    echo "</pre>";
    die("<hr/>line number=123");

    return $output;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
