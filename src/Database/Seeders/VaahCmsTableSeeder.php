<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use VaahCms\Modules\Cmd\Database\Seeds\PermissionDataTableSeeder;
use VaahCms\Modules\Cmd\Database\Seeds\RoleDataTableSeeder;
use VaahCms\Modules\Cmd\Database\Seeds\LanguageDataTableSeeder;
use VaahCms\Modules\Cmd\Database\Seeds\LanguageCategoryDataTableSeeder;

class VaahCmsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedPermissions();
        $this->seedRoles();
        $this->seedLanguages();
        $this->seedLanguageCategories();
        $this->seedSettings();

    }
    //------------------------------------------------------------
    //------------------------------------------------------------
    public function getListFromJson($json_file_name)
    {
        $json_file = __DIR__."/json/".$json_file_name;
        $jsonString = file_get_contents($json_file);
        $list = json_decode($jsonString, true);
        return $list;
    }
    //---------------------------------------------------------------
    public function storeSeeds($table, $list, $primary_key='slug', $create_slug=true, $create_slug_from='name')
    {
        foreach ($list as $item)
        {
            if($create_slug)
            {
                $item['slug'] = Str::slug($item[$create_slug_from]);
            }


            $record = DB::table($table)
                ->where($primary_key, $item[$primary_key])
                ->first();


            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where($primary_key, $item[$primary_key])
                    ->update($item);
            }
        }
    }
    //---------------------------------------------------------------
    public function storeSeedsWithUuid($table, $list, $primary_key='slug', $create_slug=true, $create_slug_from='name')
    {
        foreach ($list as $item)
        {
            if($create_slug)
            {
                $item['slug'] = Str::slug($item[$create_slug_from]);
            }

            $item['uuid'] = Str::uuid();
            $item['is_active'] = 1;

            $record = DB::table($table)
                ->where($primary_key, $item[$primary_key])
                ->first();


            if(!$record)
            {
                DB::table($table)->insert($item);
            } else{
                DB::table($table)->where($primary_key, $item[$primary_key])
                    ->update($item);
            }
        }
    }
    //---------------------------------------------------------------
    public function seedPermissions()
    {
        $list = $this->getListFromJson("permissions.json");
        $this->storeSeedsWithUuid('vh_permissions', $list);
    }
    //---------------------------------------------------------------
    public function seedRoles()
    {
        $list = $this->getListFromJson("roles.json");
        $this->storeSeedsWithUuid('vh_roles', $list);
    }
    //---------------------------------------------------------------
    public function seedLanguages()
    {

        $list = $this->getListFromJson("languages.json");

        foreach($list as $item)
        {
            $exist = \DB::table( 'vh_lang_languages' )
                ->where( 'locale_code_iso_639', $item['locale_code_iso_639'] )
                ->first();

            if (!$exist){

                if($item['locale_code_iso_639'] == 'en')
                {
                    $item['default'] = 1;
                }

                \DB::table( 'vh_lang_languages' )->insert( $item );
            }
        }

    }
    //---------------------------------------------------------------
    public function seedLanguageCategories()
    {
        $list = [
            ["name" => 'General']
        ];

        $this->storeSeeds('vh_lang_categories', $list);

    }
    //---------------------------------------------------------------
    public function seedSettings()
    {


        $list = $this->getListFromJson("settings.json");

        foreach($list as $item)
        {
            $exist = \DB::table( 'vh_settings' )
                ->where( 'category', $item['category'] )
                ->where( 'key', $item['key'] )
                ->first();

            if (!$exist){

                if(isset($item['type']) && $item['type']=='json')
                {
                    $item['value']=json_encode($item['value']);
                }

                \DB::table( 'vh_settings' )->insert( $item );
            } else{
                \DB::table( 'vh_settings' )
                    ->where( 'category', $item['category'] )
                    ->where( 'key', $item['key'] )
                    ->update($item);
            }
        }

    }
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    //---------------------------------------------------------------


}
