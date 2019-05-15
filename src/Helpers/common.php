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
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------