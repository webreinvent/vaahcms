<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Permission;


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
                                              $create_slug=true, $create_slug_from='name',
                                              $has_active=true)
    {
        foreach ($list as $item)
        {
            if($create_slug)
            {
                $item['slug'] = Str::slug($item[$create_slug_from]);
            }

            $item['uuid'] = Str::uuid();

            if($has_active){
                $item['is_active'] = 1;
            }

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
    public static function storeTaxonomyTypes($list)
    {
        foreach ($list as $item)
        {

            $table = 'vh_taxonomy_types';

            $item['slug'] = Str::slug($item['name']);

            $item['uuid'] = Str::uuid();

            $item['is_active'] = true;

            $record = DB::table($table)
                ->where('slug', $item['slug'])
                ->first();

            $item['parent_id'] = null;

            if(isset($item['parent_slug']) && $item['parent_slug']){
                $parent = DB::table($table)
                    ->where('slug', $item['parent_slug'])
                    ->first();

                if(!$parent){
                    $data = [
                        'name' => Str::title($item['parent_slug']),
                        'slug' => $item['parent_slug'],
                        'uuid' => Str::uuid(),
                        'is_active' => true
                    ];

                    DB::table($table)->insert($data);

                    $parent = DB::table($table)
                        ->where('slug', $item['parent_slug'])
                        ->first();
                }

                unset($item['parent_slug']);

                $item['parent_id'] = $parent->id;
            }

            if(isset($item['meta']))
            {
                $item['meta'] = json_encode($item['meta']);
            }

            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where('slug', $item['slug'])
                    ->update($item);
            }
        }
    }
    //----------------------------------------------------------
    public static function storeTaxonomies($list)
    {
        foreach ($list as $item)
        {

            $table = 'vh_taxonomies';
            $type_table = 'vh_taxonomy_types';

            $item['slug'] = Str::slug($item['name']);

            $item['uuid'] = Str::uuid();

            $item['is_active'] = true;

            if(!isset($item['type_slug']) || !$item['type_slug']){
                continue;
            }

            $type = DB::table($type_table)
                ->where('slug', $item['type_slug'])
                ->first();

            if(!$type){
                $data = [
                    'name' => Str::title($item['type_slug']),
                    'slug' => $item['type_slug'],
                    'uuid' => Str::uuid(),
                    'is_active' => true
                ];

                DB::table($type_table)->insert($data);

                $type = DB::table($type_table)
                    ->where('slug', $item['type_slug'])
                    ->first();
            }

            unset($item['type_slug']);

            $item['vh_taxonomy_type_id'] = $type->id;

            $record = DB::table($table)
                ->where('slug', $item['slug'])
                ->first();

            if(isset($item['meta']))
            {
                $item['meta'] = json_encode($item['meta']);
            }

            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where('slug', $item['slug'])
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
    public static function permissions($json_file_path,$app_path = null){
        $list = self::getListFromJson($json_file_path);

        $app_data = [];

        if($app_path){
            $filtered_path = str_replace("\Database\Seeds","",$app_path);
            $app_data = vh_get_module_settings_from_path($filtered_path);
        }

        foreach ($list as $item)
        {
            if(!isset($item['slug']) || !$item['slug'])
            {
                $item['slug'] = Str::slug($item['name']);
            }

            if(count($app_data) > 0){
                if(isset($app_data['name']) && $app_data['name']){
                    $item['name'] = $app_data['name'].'-'.$item['name'];
                    $item['slug'] = Str::slug($app_data['name']).'-'.$item['slug'];
                }

            }

            $item['uuid'] = Str::uuid();

            if(!isset($item['is_active']) || !$item['is_active']){
                $item['is_active'] = 1;
            }

            $record = Permission::where('slug', $item['slug'])
                ->first();

            if(isset($item['meta']))
            {
                $item['meta'] = json_encode($item['meta']);
            }

            if(!$record)
            {
                Permission::insert($item);
            } else{
                Permission::where('slug', $item['slug'])
                    ->update($item);
            }
        }
    }
    //----------------------------------------------------------
    public static function taxonomyTypes($json_file_path){
        $list = self::getListFromJson($json_file_path);

        self::storeTaxonomyTypes($list);
    }
    //----------------------------------------------------------
    public static function taxonomies($json_file_path){
        $list = self::getListFromJson($json_file_path);

        self::storeTaxonomies($list);
    }
    //----------------------------------------------------------

}
