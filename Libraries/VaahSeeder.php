<?php
namespace WebReinvent\VaahCms\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Entities\Permission;
use WebReinvent\VaahCms\Entities\Role;


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
    public static function storeTaxonomyTypes($list, $table = 'vh_taxonomy_types')
    {
        foreach ($list as $item)
        {

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
    public static function storeTaxonomies($list,
                                           $table = 'vh_taxonomies',
                                           $type_table = 'vh_taxonomy_types')
    {
        foreach ($list as $item)
        {

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
                ->where('vh_taxonomy_type_id', $item['vh_taxonomy_type_id'])
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
                    ->where('vh_taxonomy_type_id', $item['vh_taxonomy_type_id'])
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
    public static function permissions($json_file_path, $prefix = null){
        $list = self::getListFromJson($json_file_path);

        $pre_name = null;

        if($prefix)
        {
            $pre_name = $prefix;

        }else{

            $pre_name = get_string_between($json_file_path,
                DIRECTORY_SEPARATOR.'VaahCms'.DIRECTORY_SEPARATOR.'Modules'.DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Seeds');

            if(!$pre_name){
                $pre_name = get_string_between($json_file_path,
                DIRECTORY_SEPARATOR.'VaahCms'.DIRECTORY_SEPARATOR.'Themes'.DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Seeds');
            }
        }

        foreach ($list as $item)
        {
            if(!isset($item['slug']) || !$item['slug'])
            {
                $item['slug'] = Str::slug($item['name']);
            }

            if($pre_name){

                $item['name'] = $pre_name.': '.$item['name'];
                $item['slug'] = Str::slug($pre_name).'-'.$item['slug'];

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

            $roles = [];

            if(isset($item['roles']) && is_array($item['roles'])
                && count($item['roles']) > 0){
                $roles = $item['roles'];
                unset($item['roles']);

            }

            if(!$record)
            {
                Permission::insert($item);
            } else{
                Permission::where('slug', $item['slug'])
                    ->update($item);
            }

            if(count($roles) === 0){
                continue;
            }
            $permission= Permission::where('slug', $item['slug'])
                ->first();
            foreach ($roles as $role_slug)
            {
                $role= Role::where('slug', $role_slug)
                    ->first();

                if(!$role){
                    continue;
                }

                if (!$role->permissions()
                    ->wherePivot('vh_permission_id', $permission->id)->exists()) {
                    $role->permissions()->attach($permission, ['is_active'=>true]);
                } else {
                    $role->permissions()->updateExistingPivot($permission, ['is_active'=>true]);
                }

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
