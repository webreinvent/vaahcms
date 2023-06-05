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
function vh_is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
//-------------------------------------------------------------
function vh_find_in_array_by_key_value($array,$key,$value)
{
    foreach ($array as $item){
        if($item[$key] == $value){
            return $item;
        }
    }

    return null;
}
//-------------------------------------------------------------
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
//-------------------------------------------------------------
function vh_response($response)
{
    if(version_compare(config('vaahcms.version'), '2.0.0', '<' )){
        $is_vaahcms_two = false;
    } else{
        $is_vaahcms_two = true;
    }

    /*
     * VaahCMS 1.x Response
     */
    if($is_vaahcms_two === false && isset($response['status'])){
        return $response;
    }

    if($is_vaahcms_two === false && isset($response['success'])){
        if($response['success'] === true)
        {
            $response['status'] = 'success';
        } else{
            $response['status'] = 'failed';
        }
        unset($response['success']);
        return $response;
    }

    /*
     * VaahCMS 2.x Response
     */
    if($is_vaahcms_two === true && isset($response['success'])){
        return $response;
    }

    if($is_vaahcms_two === true && isset($response['status'])){
        $response['success'] = $response['status'];
        unset($response['status']);
        return $response;
    }

    return $response;
}
//-------------------------------------------------------------
