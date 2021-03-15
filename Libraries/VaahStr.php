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

        $string = static::translateDynamicStringsOfParams($string, $params);
        $string = static::translateDynamicStringsOfEnv($string);
        $string = static::translateDynamicStringsOfRoutes($string);
        $string = static::translateDynamicStringsOfPublicUrls($string,$params);

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
    public static function translateDynamicStringsOfPublicUrls($string,$params = [])
    {
        $extend = new \WebReinvent\VaahCms\Http\Controllers\ExtendController();

        $dynamic_strings = $extend->getPublicUrls();

        if($dynamic_strings && $dynamic_strings['status'] === 'success'){
            foreach ($dynamic_strings['data'] as $dynamic_string){

                if(count($params) > 0 && isset($params['has_replace_string'])
                    && $params['has_replace_string']){
                    $string = str_replace($dynamic_string['value'],$dynamic_string['name'],$string);
                }else{
                    $string = str_replace($dynamic_string['name'],$dynamic_string['value'],$string);
                }

            }
        }

        return $string;

    }
    //----------------------------------------------------------

}
