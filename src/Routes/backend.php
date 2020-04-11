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
include('backend/settings.php');

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
        Route::any( '/permissions', 'JsonController@getPermissions' )
            ->name( 'vh.backend.json.permissions' );
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
        Route::any('/item/{id}/createUser', 'RegistrationsController@createUser')
            ->name('backend.vaah.registrations.item.createUser');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'RegistrationsController@postStore')
            ->name('backend.vaah.registrations.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'RegistrationsController@postActions')
            ->name('backend.vaah.registrations.actions');
        //---------------------------------------------------------
    });



//=================OLD ROUTES===========================================




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
        'prefix' => 'backend/vaah/users',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'UsersController@getAssets')
            ->name('backend.vaah.users.assets');
        //---------------------------------------------------------
        Route::post('/create', 'UsersController@postCreate')
            ->name('backend.vaah.users.create');
        //---------------------------------------------------------
        Route::post('/list', 'UsersController@getList')
            ->name('backend.vaah.users.list');
        //---------------------------------------------------------
        Route::any('/item/{id}', 'UsersController@getItem')
            ->name('backend.vaah.users.item');
        //---------------------------------------------------------
        Route::any('/item/{id}/roles', 'UsersController@getItemRoles')
            ->name('backend.vaah.users.role');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'UsersController@postStore')
            ->name('backend.vaah.users.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'UsersController@postActions')
            ->name('backend.vaah.users.actions');
        //---------------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/roles',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'RolesController@index' )
            ->name( 'vh.backend.roles' );
        //------------------------------------------------
        Route::any( '/assets', 'RolesController@getAssets' )
            ->name( 'vh.backend.roles.assets' );
        //---------------------------------------------------------
        Route::post('/create', 'RolesController@postCreate')
            ->name('backend.vaah.registrations.create');
        //------------------------------------------------
        Route::any( '/list', 'RolesController@getList' )
            ->name( 'vh.backend.roles.list' );
        //------------------------------------------------
        Route::any('/item/{id}', 'RolesController@getItem')
            ->name('backend.vaah.roles.item');
        //---------------------------------------------------------
        Route::any('/item/{id}/permissions', 'RolesController@getItemPermission')
            ->name('backend.vaah.roles.item.permissions');
        //---------------------------------------------------------
        Route::any('/item/{id}/users', 'RolesController@getItemUser')
            ->name('backend.vaah.roles.item.users');
        //---------------------------------------------------------
        Route::post('/getModuleSections', 'RolesController@getModuleSections')
            ->name('backend.vaah.permissions.module-section');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'RolesController@postStore')
            ->name('backend.vaah.roles.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'RolesController@postActions')
            ->name('backend.vaah.roles.actions');
        //---------------------------------------------------------
        //------------------------------------------------
    });

Route::group(
    [
        'prefix' => 'backend/vaah/permissions',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'PermissionsController@getAssets')
            ->name('backend.vaah.permissions.assets');
        //---------------------------------------------------------
        Route::any('/list', 'PermissionsController@getList')
            ->name('backend.vaah.permissions.list');
        //---------------------------------------------------------
        Route::any('/item/{id}', 'PermissionsController@getItem')
            ->name('backend.vaah.permissions.item');
        //---------------------------------------------------------
        Route::any('/item/{id}/roles', 'PermissionsController@getItemRoles')
            ->name('backend.vaah.permissions.role');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'PermissionsController@postStore')
            ->name('backend.vaah.permissions.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'PermissionsController@postActions')
            ->name('backend.vaah.permissions.actions');
        //---------------------------------------------------------
        Route::post('/getModuleSections', 'PermissionsController@getModuleSections')
            ->name('backend.vaah.permissions.module-section');
        //---------------------------------------------------------
    });
