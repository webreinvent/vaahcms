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
