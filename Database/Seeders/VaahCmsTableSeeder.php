<?php namespace WebReinvent\VaahCms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebReinvent\VaahCms\Libraries\VaahSeeder;

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
        $this->seedLanguageStrings();
        $this->seedSettings();
        $this->seedNotifications();
        $this->seedNotificationContent();
        $this->seedTaxonomyTypes();
        $this->seedTaxonomies();

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
    public function storeSeedsWithUuid($table, $list,
                                       $has_active=true,
                                       $primary_key='slug',
                                       $create_slug=true,
                                       $create_slug_from='name')
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
        $json_file_path = __DIR__."/json/permissions.json";
        VaahSeeder::permissions($json_file_path);
    }
    //---------------------------------------------------------------
    public function seedTaxonomies()
    {
        $json_file_path = __DIR__."/json/taxonomies.json";
        VaahSeeder::taxonomies($json_file_path);
    }
    //---------------------------------------------------------------
    public function seedTaxonomyTypes()
    {
        $json_file_path = __DIR__."/json/taxonomy_types.json";
        VaahSeeder::taxonomyTypes($json_file_path);
    }
    //---------------------------------------------------------------
    public function seedRoles()
    {
        $json_file_path = __DIR__."/json/roles.json";
        VaahSeeder::roles($json_file_path);
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
    public function seedLanguageStrings()
    {

        $list = $this->getListFromJson("language_strings.json");

        foreach($list as $item)
        {

            $item['slug'] = Str::slug($item['name'],'_');

            $exist = \DB::table( 'vh_lang_strings' )
                ->where( 'slug',  $item['slug'] )
                ->first();


            $lang = \DB::table( 'vh_lang_languages' )
                ->where( 'locale_code_iso_639', 'en' )
                ->first();

            $cat = \DB::table( 'vh_lang_categories' )
                ->where( 'slug', $item['category'] )
                ->first();


            if (!$exist && $lang && $cat){

                $item['vh_lang_language_id'] = $lang->id;

                $item['vh_lang_category_id'] = $cat->id;

                unset($item['category']);

                \DB::table( 'vh_lang_strings' )->insert( $item );
            }
        }

    }
    //---------------------------------------------------------------
    public function seedLanguageCategories()
    {
        $list = [
            ["name" => 'General'],
            ["name" => 'User'],
            ["name" => 'Media'],
            ["name" => 'Localization'],
            ["name" => 'Login']
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
    public function seedNotifications()
    {
        $list = $this->getListFromJson("notifications.json");
        $this->storeSeedsWithUuid('vh_notifications', $list,false);
    }


    //---------------------------------------------------------------
    public function seedNotificationContent()
    {
        $list = $this->getListFromJson("notification_contents.json");

        foreach($list as $item)
        {
            $notification = \DB::table( 'vh_notifications' )
                ->where( 'slug', $item['slug'] )
                ->first();

            $exist = \DB::table( 'vh_notification_contents' )
                ->where( 'vh_notification_id', $notification->id )
                ->where('sort',  $item['sort'])
                ->where('via',  $item['via'])
                ->first();

            $item['vh_notification_id'] = $notification->id;

            if(isset($item['meta'])){
                $item['meta'] = json_encode($item['meta']);
            }

            unset($item['slug']);


            if(!$exist)
            {
                DB::table('vh_notification_contents')->insert($item);
            } else{
                DB::table('vh_notification_contents')
                    ->where( 'vh_notification_id', $notification->id )
                    ->where('sort',  $item['sort'])
                    ->where('via',  $item['via'])
                    ->update($item);
            }
        }
    }
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    //---------------------------------------------------------------


}
