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

        $string = static::translateDynamicStringsOfRoutes($string);

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
    public static function translateDynamicStringsOfRoutes($string)
    {


        $pattern = '/#!ROUTE:(.*?)!#/';

        preg_match_all($pattern, $string, $matches);

        $map = [];

        if(count($matches[1]) > 0)
        {
            foreach ($matches[1] as $item)
            {
                $route = strtolower($item);
                $route = route($route);
                $map['#!ROUTE:'.$item.'!#'] = $route;
            }
        }

        $string = strtr($string, $map);

        return $string;
    }
    //----------------------------------------------------------

}
