<?php

function errorsToArray($errors)
{
    $errors = $errors->toArray();
    $error = array();
    foreach ($errors as $error_list) {
        foreach ($error_list as $item) {
            $error[] = $item;
        }
    }
    return $error;
}

//-------------------------------------------------------------
function vh_get_avatar_by_email($email)
{
    try {
        $image = \Gravatar::fallback("/images/user.png")->get($email);
    } catch (Exception $e) {
        $image = asset("assets/core/images/user.png");
    }
    return $image;
}
//-------------------------------------------------------------
function vh_get_user_statuses()
{
    $list = [
        1 => 'active',
        50 => 'banned',
    ];

    return $list;
}
//-------------------------------------------------------------
function slug_to_str($slug)
{
    $slug = str_replace('-', ' ', $slug);
    $slug = str_replace('_', ' ', $slug);
    $str = ucwords($slug);

    return $str;
}
//-------------------------------------------------------------
function generate_random_string($length=8)
{
    return \Str::random($length);
}
//-------------------------------------------------------------
function generate_password()
{
    return generate_random_string();
}
//-------------------------------------------------------------
function vh_list_with_slugs($arr)
{
    $list = [];
    $i = 0;
    foreach ($arr as $item)
    {
        $list[$i]['slug'] = \Str::slug($item);
        $list[$i]['name'] = $item;
        $i++;
    }

    return $list;
}
//-------------------------------------------------------------
function vh_action($class_namespace, $method, $params=null) {
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

    return vh_action($namespace, $method, $params);
}
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
