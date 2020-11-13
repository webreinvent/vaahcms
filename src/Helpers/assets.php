<?php


//-----------------------------------------------------------------------------------
function vh_statuses()
{
    $list = [
      ['slug' => 'active', 'name'=>'Active'],
      ['slug' => 'inactive', 'name'=>'Inactive'],
      ['slug' => 'blocked', 'name'=>'Blocked'],
      ['slug' => 'banned', 'name'=>'Banned'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_general_bulk_actions()
{
    $list = [
        ['slug' => 'bulk-change-status', 'name'=>'Change Status'],
        ['slug' => 'bulk-trash', 'name'=>'Trash'],
        ['slug' => 'bulk-restore', 'name'=>'Restore'],
        ['slug' => 'bulk-delete', 'name'=>'Delete'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_registration_statuses()
{
    $list = [
        ['slug' => 'email-verification-pending', 'name'=>'Email Verification Pending'],
        ['slug' => 'email-verified', 'name'=>'Email Verified'],
        ['slug' => 'user-created', 'name'=>'User Created'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_name_titles()
{
    $list = [
        ['slug' => 'Mr', 'name' => 'Mr'],
        ['slug' => 'Miss', 'name' => 'Miss'],
        ['slug' => 'Mrs', 'name' => 'Mrs'],
        ['slug' => 'Ms', 'name' => 'Ms'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_genders()
{
    $list = [
        ['slug' => 'm', 'name'=>'Male'],
        ['slug' => 'f', 'name'=>'Female'],
        ['slug' => 'o', 'name'=>'Other'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_is_active_options()
{
    $list = [
        ['slug' => 0, 'name'=>'No'],
        ['slug' => 1, 'name'=>'Yes'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_user_statuses()
{
    $list = [
        ['slug' => 'active', 'name'=>'Active'],
        ['slug' => 'inactive', 'name'=>'In Active'],
        ['slug' => 'blocked', 'name'=>'Blocked'],
        ['slug' => 'banned', 'name'=>'Banned'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------
function vh_environments()
{
    $arr = [
        'Custom',
        'Local',
        'Develop',
        'Release',
        'Hotfix',
        'Production'
    ];


    $files = vh_get_all_files(base_path());

    $env_list = [];

    foreach ($files as $file)
    {
        if (strpos($file, '.env.') !== false) {
            $file = str_replace(".env.", "", $file);

            if($file == 'example' || $file == 'example.default')
            {
                continue;
            }

            $env_list[] = ucfirst($file);
        }
    }


    if(count($env_list) > 0)
    {
        $arr = array_unique(array_merge($arr, $env_list));
    }

    $list = vh_list_with_slugs($arr);

    return $list;
}
//-----------------------------------------------------------------------------------
function vh_database_types()
{
    $list = [
        ['slug' => 'mysql', 'name'=>'MySQL'],
        ['slug' => 'pgsql', 'name'=>'PostgreSQL'],
        ['slug' => 'sqlite', 'name'=>'SQLite'],
        ['slug' => 'sqlsrv', 'name'=>'SQL Server'],
    ];


    return $list;
}
//-----------------------------------------------------------------------------------
function vh_mail_encryption_types()
{
    $list = [
        ['slug' => 'none', 'name'=>'None'],
        ['slug' => 'ssl', 'name'=>'SSL'],
        ['slug' => 'tls', 'name'=>'TLS'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_mail_sample_settings()
{
    $list = [
        [
            'slug' => 'mailtrap',
            'name'=>'MailTrap',
            'settings'=>[
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.mailtrap.io',
                'mail_port' => '2525',
                'mail_encryption' => 'none',
            ]
        ],
        [
            'slug' => 'gmail',
            'name'=>'GMail',
            'settings'=>[
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => '587',
                'mail_encryption' => 'tls',
            ]
        ],
        [
            'slug' => 'other',
            'name'=>'Other'
        ],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_file_types()
{

    //get list from https://gist.github.com/plasticbrain/3887245
    $arr = [
        'text/html',
        'image/x-icon',
        'text/plain',
        'image/jpeg',
        'video/mpeg', 'video/quicktime', 'audio/mpeg', 'audio/x-mpeg',
        'image/png', 'application/msword', 'application/excel', 'image/jpeg',
        'image/gif',  'audio/mp4',  'video/mp4',
    ];

    $arr = array_unique(array_filter($arr));

    $list = vh_list_with_slugs($arr);

    return $list;
}
//-----------------------------------------------------------------------------------
function vh_meta_attributes()
{
    $list = [
        ['slug' => 'name', 'name'=>'name'],
        ['slug' => 'property', 'name'=>'property'],
    ];
    return $list;
}
//-----------------------------------------------------------------------------------
function vh_notification_variables()
{
    $list = [
        [
            'name'=>'#!USER:NAME!#',
            'details'=>'Will be replaced with name.',
        ],
        [
            'name'=>'#!USER:DISPLAY_NAME!#',
            'details'=>'Will be replaced with display name.',
        ],
        [
            'name'=>'#!USER:EMAIL!#',
            'details'=>'Will be replaced with email.',
        ],
        [
            'name'=>'#!USER:PHONE!#',
            'details'=>'Will be replaced with phone.',
        ]
    ];

    return $list;

}
//-----------------------------------------------------------------------------------
function vh_notification_actions()
{
    $list = [
        [
            'name'=>'#!ROUTE:VH.LOGIN!#'
        ],
        [
            'name'=>'#!ROUTE:VH.REGISTER!#'
        ],
        [
            'name'=>'#!ROUTE:VH.RESET!#'
        ],
        [
            'name'=>'#!ROUTE:VH.VERIFICATION!#'
        ],
    ];

    return $list;

}
//-----------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------
