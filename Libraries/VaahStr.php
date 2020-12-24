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

        $user = null;

        if(isset($params['user_id']))
        {
            $user = User::where('id',$params['user_id'])
            ->first();
            $string = static::translateDynamicStringsOfUser($string, $user);
        }


       $string = static::translateDynamicStringsOfParams($string, $params);
       $string = static::translateDynamicStringsOfEnv($string, $params);
        $string = static::translateDynamicStringsOfRoutes($string, $params, $user);

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
    public static function translateDynamicStringsOfParams($string, $params)
    {
        $pair = $params;
        $pair = array_change_key_case($pair, CASE_UPPER);
        $codes = $pair;
        $pattern = '#!PARAM:%s!#';

        $map = array();
        foreach($codes as $var => $value) {
            $map[sprintf($pattern, $var)] = $value;
        }

        $string = strtr($string, $map);
        return $string;
    }
    //----------------------------------------------------------
    public static function translateDynamicStringsOfEnv($string)
    {
        $pair = $_ENV;

        $pair = array_change_key_case($pair, CASE_UPPER);
        $codes = $pair;
        $pattern = '#!ENV:%s!#';

        $map = array();
        foreach($codes as $var => $value) {
            $map[sprintf($pattern, $var)] = $value;
        }

        $string = strtr($string, $map);


        return $string;
    }
    //----------------------------------------------------------
    public static function translateDynamicStringsOfRoutes($string,$params,$user=null)
    {


        $pattern = '/#!ROUTE:(.*?)!#/';

        preg_match_all($pattern, $string, $matches);

        $map = [];


        if(count($matches[1]) > 0)
        {
            foreach ($matches[1] as $item)
            {
                $route_name = strtolower($item);

                switch ($route_name)
                {
                    case 'vh.reset':
                        $route = route($route_name,
                            ['reset_password_code' => $user->reset_password_code]
                        );
                        break;
                    default:
                        $route = route($route_name);
                        break;
                }

                $map['#!ROUTE:'.$item.'!#'] = $route;
            }
        }

        $string = strtr($string, $map);

        return $string;
    }
    //----------------------------------------------------------

}
