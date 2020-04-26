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
function vh_vaahcms_action($method)
{

    $namespace = '\WebReinvent\VaahCms\Http\Controllers\ExtendController';

    $response = vh_action_response($namespace, $method);

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
function vh_module_action($method, $flat_array=null)
{

    $active_modules = Module::getActiveModules();

    if(count($active_modules) < 1)
    {
        return [];
    }

    $list = [];

    foreach ($active_modules as $item)
    {
        $res = vh_module_action_response($item->name, 'ExtendController@'.$method);

        if($res['status'] == 'failed')
        {
            continue;
        } elseif(isset($res['status']) && $res['status'] == 'success'
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {
            if(!$flat_array)
            {
                $list[$item->slug] = $res['data'];
            } else{
                $list[] = $res['data'];
            }
        }
    }

    return $list;

}

//-------------------------------------------------------------
function vh_theme_action($method, $flat_array=null)
{

    $list = Theme::getActiveThemes();

    if(count($list) < 1)
    {
        return [];
    }

    $list = [];

    foreach ($list as $item)
    {
        $res = vh_module_action_response($item->name, 'ExtendController@'.$method);

        if($res['status'] == 'failed')
        {
            continue;
        } elseif(isset($res['status']) && $res['status'] == 'success'
            && isset($res['data']) && count(array_filter($res['data'])) > 0)
        {
            if(!$flat_array)
            {
                $list[$item->slug] = $res['data'];
            } else{
                $list[] = $res['data'];
            }
        }
    }

    return $list;

}
//-------------------------------------------------------------
function vh_action($method, $flat_array=null){

    if(!$flat_array)
    {
        $list['vaahcms'] = vh_vaahcms_action($method, $flat_array);
        $list['modules'] = vh_module_action($method, $flat_array);
        $list['themes'] = vh_theme_action($method, $flat_array);
    } else{
        $list['vaahcms'] = vh_vaahcms_action($method, $flat_array);
        $list['modules'] = vh_module_action($method, $flat_array);
        $list['themes'] = vh_theme_action($method, $flat_array);

        $list = array_merge($list['vaahcms'], $list['modules'], $list['themes']);

    }


    return $list;
}
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
