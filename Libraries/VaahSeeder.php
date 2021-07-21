<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class VaahSeeder{

    //----------------------------------------------------------
    public static function getListFromJson($json_file_path)
    {
        $jsonString = file_get_contents($json_file_path);
        $list = json_decode($jsonString, true);
        return $list;
    }
    //----------------------------------------------------------
    public static function getJsonData($json_file_path)
    {
        $jsonString = file_get_contents($json_file_path);
        return json_decode($jsonString, true);
    }
    //----------------------------------------------------------
    public static function storeSeedsWithUuid($table, $list, $primary_key='slug',
                                              $create_slug=true, $create_slug_from='name')
    {
        foreach ($list as $item)
        {
            if($create_slug)
            {
                $item['slug'] = Str::slug($item[$create_slug_from]);
            }

            $item['uuid'] = Str::uuid();

            $record = DB::table($table)
                ->where($primary_key, $item[$primary_key])
                ->first();

            if(isset($item['meta']))
            {
                $item['meta'] = json_encode($item['meta']);
            }

            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where($primary_key, $item[$primary_key])
                    ->update($item);
            }
        }
    }
    //----------------------------------------------------------
    public static function roles($json_file_path){

        $list = self::getListFromJson($json_file_path);
        self::storeSeedsWithUuid('vh_roles', $list);
    }
    //----------------------------------------------------------
    public static function permissions($json_file_path){
        $list = self::getListFromJson($json_file_path);
        self::storeSeedsWithUuid('vh_permissions', $list);
    }
    //----------------------------------------------------------

}
