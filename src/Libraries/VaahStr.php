<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use WebReinvent\VaahCms\Entities\User;
use WebReinvent\VaahCms\Notifications\TestSmtp;

use Dotenv\Dotenv;

class VaahStr{

    //----------------------------------------------------------
    public static function translateDynamicStrings($params)
    {
        $string = $params['string'];


        if(isset($params['user_id']))
        {
            $user = User::find($params['user_id']);

            $string = static::translateDynamicStringsOfUser($string, $user);
        }

        return $string;
    }
    //----------------------------------------------------------
    public static function translateDynamicStringsOfUser($string, User $user)
    {
        $pair = $user->toArray();
        $pair = array_change_key_case($pair, CASE_UPPER);
        $codes = $pair;
        $pattern = '#!USER:%s!#';

        $map = array();
        foreach($codes as $var => $value) {
            $map[sprintf($pattern, $var)] = $value;
        }

        $string = strtr($string, $map);
        return $string;
    }
    //----------------------------------------------------------
    //----------------------------------------------------------

}
