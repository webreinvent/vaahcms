<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    function seedPermissions()
    {
        $permissions = [
            'Can Access Admin Section',
            'Can Manage Users',
        ];

        $list = [];
        foreach ($permissions as $permission)
        {
            $list[] = [
                'name' => $permission,
                'slug' => Str::slug($permission),
                'module' => 'vaahcms',
                'section' => 'admin',
                'details' => 'This will allow user to access admin control panel',
                'is_active' => 1,
            ];
        }


        foreach($list as $item)
        {
            $exist = \DB::table( 'vh_permissions' )
                ->where( 'slug', $item['slug'] )
                ->first();

            if (!$exist){
                \DB::table( 'vh_permissions' )->insert( $item );
            }
        }

    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    function seedRoles()
    {
        $list = [
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'details' => 'Users who have admin roles has all the permission access and manage the data.',
                'is_active' => 1,
            ],
            [
                'name' => 'Registered',
                'slug' => 'registered',
                'details' => 'Users who have registered roles can access only public website.',
                'is_active' => 1,
            ],
        ];


        foreach($list as $item)
        {
            $exist = \DB::table( 'vh_roles' )
                ->where( 'slug', $item['slug'] )
                ->first();

            if (!$exist){
                \DB::table( 'vh_roles' )->insert( $item );
            }
        }

    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    function seedLanguages()
    {

        $list = file_get_contents(__DIR__.'/json/languages.json');
        $list = json_decode($list, true);


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

    /**
     * Run the database seeds.
     *
     * @return void
     */
    function seedLanguageCategories()
    {
        $row_list = [
            'General',
        ];

        $list = [];
        foreach ($row_list as $row_item)
        {
            $list[] = [
                'name' => $row_item,
                'slug' => Str::slug($row_item),
            ];
        }


        foreach($list as $item)
        {
            $exist = \DB::table( 'vh_lang_categories' )
                ->where( 'slug', $item['slug'] )
                ->first();

            if (!$exist){
                \DB::table( 'vh_lang_categories' )->insert( $item );
            }
        }

    }


}
