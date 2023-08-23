<?php
namespace WebReinvent\VaahCms\Libraries;

use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Models\Permission;
use WebReinvent\VaahCms\Models\User;


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
    public static function fill($request)
    {
        $rules = array(
            'model_namespace' => 'required',
        );

        $messages = [
            'model_namespace.required' => "model_namespace is required. Eg: WebReinvent\VaahCms\Models\User"
        ];

        $validator = \Validator::make( $request->all(), $rules, $messages);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['success'] = false;
            $response['errors'] = $errors;
            return $response;
        }

        $model = $request->model_namespace;
        $model = new $model();

        $table = $model->getTable();

        if($request->filled('fillable'))
        {
            $fillable = $request->fillable;
        } else{
            $fillable = $model->getFillable();
        }

        if($request->filled('except'))
        {
            $except = $request->except;
            $fillable = array_diff($fillable,$except);
        };

        $faker = Factory::create();

        $fill = [];
        $list = [];

        $i = 0;
        foreach ($fillable as $column)
        {
            $type = \DB::getSchemaBuilder()->getColumnType($table, $column);

            $value = null;

            switch($type)
            {

                case 'text':
                    $value = $faker->text(60);
                    break;

                case 'string':
                    $value = $faker->text(25);
                    break;

                case 'boolean':
                    $value = array_rand([0,1]);
                    break;



            }

            $list[$i]['column'] = $column;
            $list[$i]['type'] = $type;
            $list[$i]['value'] = $value;
            $fill[$column] = $value;
            $i++;

        }


        foreach ($fill as $column => $value)
        {
            switch ($column){

                case 'first_name':
                    $fill[$column] = $faker->firstName;
                    break;

                case 'last_name':
                case 'middle_name':
                    $fill[$column] = $faker->lastName;
                    break;

                case 'alternate_email':
                case 'email':
                    $fill[$column] = $faker->email;
                    break;

                case 'password':
                    $fill[$column] = $faker->password;
                    break;

                case 'gender':
                    $fill[$column] = $faker->randomElement(['m','f','o']);
                    break;


                case 'timezone':
                    $fill[$column] = $faker->timezone('US');
                    break;

                case 'display_name':
                case 'username':
                    $fill[$column] = $faker->userName;
                    break;


                case 'slug':
                    if(isset($fill['name']) && !empty($fill['name']))
                    {
                        $fill[$column] = \Str::slug($fill['name']);
                    }
                    break;

                case 'created_by':
                case 'updated_by':
                    $fill[$column] = User::inRandomOrder()->first()->id;
                    break;

            }
        }


        $data['fill']=$fill;
        $data['list']=$list;

        $response['success'] = true;
        $response['data'] = $data;
        return $response;
    }
    //----------------------------------------------------------

    //----------------------------------------------------------

}
