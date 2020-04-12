<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include('backend/ui.php');
include('backend/setup.php');

Route::group(
    [
        'prefix'     => 'backend/json',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'JsonController@getPublicAssets' )
            ->name( 'vh.backend.json.assets' );
        //------------------------------------------------
        Route::any( '/is-logged-in', 'JsonController@isLoggedIn' )
            ->name( 'vh.backend.json.is_logged_in' );
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Frontend'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::any( '/signin/post', 'PublicController@postLogin' )
            ->name( 'vh.backend.signin.post' );
        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix' => 'backend/vaah/registrations',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'RegistrationsController@getAssets')
            ->name('backend.vaah.registrations.assets');
        //---------------------------------------------------------
        Route::post('/create', 'RegistrationsController@postCreate')
            ->name('backend.vaah.registrations.create');
        //---------------------------------------------------------
        Route::post('/list', 'RegistrationsController@getList')
            ->name('backend.vaah.registrations.list');
        //---------------------------------------------------------
        Route::any('/item/{id}', 'RegistrationsController@getItem')
            ->name('backend.vaah.registrations.item');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'RegistrationsController@postStore')
            ->name('backend.vaah.registrations.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'RegistrationsController@postActions')
            ->name('backend.vaah.registrations.actions');
        //---------------------------------------------------------
    });




/*Route::group(
    [
        'prefix'     => 'backend/vaah/registrations',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'RegistrationController@index' )
            ->name( 'vh.backend.registrations' );
        //------------------------------------------------
        Route::any( '/assets', 'RegistrationController@assets' )
            ->name( 'vh.backend.registrations.assets' );
        //------------------------------------------------
        Route::any( '/list', 'RegistrationController@getList' )
            ->name( 'vh.backend.registrations.list' );
        //------------------------------------------------
        Route::any( '/actions', 'RegistrationController@actions' )
            ->name( 'vh.backend.registrations.actions' );
        //------------------------------------------------
        Route::any( '/store', 'RegistrationController@store' )
            ->name( 'vh.backend.registrations.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'RegistrationController@getDetails' )
            ->name( 'vh.backend.registrations.view' );
        //------------------------------------------------
    });*/



//=================OLD ROUTES===========================================





include('backend/settings.php');





Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Frontend'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'PublicController@login' )
            ->name( 'vh.backend' );
        //------------------------------------------------
        Route::get( '/login', 'PublicController@redirectToLogin' )
            ->name( 'vh.backend.login' );
        //------------------------------------------------
        Route::post( '/login/post', 'PublicController@postLogin' )
            ->name( 'vh.backend.login.post' );
        //------------------------------------------------
        Route::get( '/logout', 'PublicController@logout' )
            ->name( 'vh.backend.logout' );
        //------------------------------------------------
        //------------------------------------------------
    });



Route::group(
    [
        'prefix'     => 'admin',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/dashboard', 'DashboardController@index' )
            ->name( 'vh.backend.dashboard' );
        //------------------------------------------------
        Route::get( '/layout/app', 'DashboardController@layoutApp' )
            ->name( 'vh.backend.layout.app' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });





Route::group(
    [
        'prefix'     => 'admin/vaah',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'DashboardController@vaah' )
            ->name( 'vh.backend.vaah' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });






Route::group(
    [
        'prefix'     => 'admin/vaah/modules',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'ModuleController@index' )
            ->name( 'vh.backend.modules' );
        //------------------------------------------------
        Route::any( '/assets', 'ModuleController@assets' )
            ->name( 'vh.backend.modules.assets' );
        //------------------------------------------------
        Route::any( '/download', 'ModuleController@download' )
            ->name( 'vh.backend.modules.download' );
        //------------------------------------------------
        Route::any( '/list', 'ModuleController@getList' )
            ->name( 'vh.backend.modules.list' );
        //------------------------------------------------
        Route::any( '/actions', 'ModuleController@actions' )
            ->name( 'vh.backend.modules.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ModuleController@getModulesSlugs' )
            ->name( 'vh.backend.modules.get.slugs' );
        //------------------------------------------------
        Route::any( '/update/versions', 'ModuleController@updateModuleVersions' )
            ->name( 'vh.backend.modules.update.version' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ModuleController@installUpdates' )
            ->name( 'vh.backend.modules.install.updates' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'admin/vaah/themes',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'ThemeController@index' )
            ->name( 'vh.backend.themes' );
        //------------------------------------------------
        Route::any( '/assets', 'ThemeController@assets' )
            ->name( 'vh.backend.themes.assets' );
        //------------------------------------------------
        Route::any( '/download', 'ThemeController@download' )
            ->name( 'vh.backend.themes.download' );
        //------------------------------------------------
        Route::any( '/list', 'ThemeController@getList' )
            ->name( 'vh.backend.themes.list' );
        //------------------------------------------------
        Route::any( '/actions', 'ThemeController@actions' )
            ->name( 'vh.backend.themes.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ThemeController@getModulesSlugs' )
            ->name( 'vh.backend.themes.get.slugs' );
        //------------------------------------------------
        Route::any( '/update/versions', 'ThemeController@updateModuleVersions' )
            ->name( 'vh.backend.themes.update.version' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ThemeController@installUpdates' )
            ->name( 'vh.backend.themes.install.updates' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });



Route::group(
    [
        'prefix'     => 'admin/composer',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/install', 'ComposerController@install' )
            ->name( 'vh.backend.composer.install' );
        //------------------------------------------------
        //------------------------------------------------
    });




Route::group(
    [
        'prefix'     => 'admin/vaah/users',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'UserController@index' )
            ->name( 'vh.backend.users' );
        //------------------------------------------------
        Route::any( '/assets', 'UserController@assets' )
            ->name( 'vh.backend.users.assets' );
        //------------------------------------------------
        Route::any( '/list', 'UserController@getList' )
            ->name( 'vh.backend.users.list' );
        //------------------------------------------------
        Route::any( '/actions', 'UserController@actions' )
            ->name( 'vh.backend.users.actions' );
        //------------------------------------------------
        Route::any( '/store', 'UserController@store' )
            ->name( 'vh.backend.users.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'UserController@getDetails' )
            ->name( 'vh.backend.users.view' );
        //------------------------------------------------
        Route::any( '/roles/{id}', 'UserController@getRoles' )
            ->name( 'vh.backend.users.roles' );
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'admin/vaah/roles',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'RoleController@index' )
            ->name( 'vh.backend.roles' );
        //------------------------------------------------
        Route::any( '/assets', 'RoleController@assets' )
            ->name( 'vh.backend.roles.assets' );
        //------------------------------------------------
        Route::any( '/list', 'RoleController@getList' )
            ->name( 'vh.backend.roles.list' );
        //------------------------------------------------
        Route::any( '/actions', 'RoleController@actions' )
            ->name( 'vh.backend.roles.actions' );
        //------------------------------------------------
        Route::any( '/store', 'RoleController@store' )
            ->name( 'vh.backend.roles.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'RoleController@getDetails' )
            ->name( 'vh.backend.roles.view' );
        //------------------------------------------------
        Route::any( '/permissions/{id}', 'RoleController@getPermissions' )
            ->name( 'vh.backend.roles.permissions' );
        //------------------------------------------------
        Route::any( '/users/{id}', 'RoleController@getUsers' )
            ->name( 'vh.backend.roles.users' );
        //------------------------------------------------
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'admin/vaah/permissions',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'PermissionController@index' )
            ->name( 'vh.backend.permissions' );
        //------------------------------------------------
        Route::any( '/assets', 'PermissionController@assets' )
            ->name( 'vh.backend.permissions.assets' );
        //------------------------------------------------
        Route::any( '/list', 'PermissionController@getList' )
            ->name( 'vh.backend.permissions.list' );
        //------------------------------------------------
        Route::any( '/actions', 'PermissionController@actions' )
            ->name( 'vh.backend.permissions.actions' );
        //------------------------------------------------
        Route::any( '/store', 'PermissionController@store' )
            ->name( 'vh.backend.permissions.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'PermissionController@getDetails' )
            ->name( 'vh.backend.permissions.view' );
        //------------------------------------------------
        Route::any( '/roles/{id}', 'PermissionController@getRoles' )
            ->name( 'vh.backend.permissions.roles' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
