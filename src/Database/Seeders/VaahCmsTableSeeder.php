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
                'name' => 'Admin',
                'slug' => 'admin',
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



}
