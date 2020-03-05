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

include('admin/ui.php');

Route::group(
    [
        'prefix'     => 'admin/json',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::any( '/assets', 'JsonController@getPublicAssets' )
            ->name( 'vh.admin.json.assets' );
        //------------------------------------------------
        Route::any( '/is-logged-in', 'JsonController@isLoggedIn' )
            ->name( 'vh.admin.json.is_logged_in' );
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'admin',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::any( '/signin/post', 'PublicController@postLogin' )
            ->name( 'vh.admin.signin.post' );
        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
    });


//=================OLD ROUTES===========================================





include('admin/settings.php');

Route::group(
    [
        'prefix'     => 'vaahcms/setup',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'SetupController@index' )
            ->name( 'vh.setup.index' );
        //------------------------------------------------
        Route::post( '/check/status', 'SetupController@checkSetupStatus' )
            ->name( 'vh.setup.check.status' );
        //------------------------------------------------
        Route::post( '/store/app/info', 'SetupController@storeAppInfo' )
            ->name( 'vh.setup.store.app.info' );
        //------------------------------------------------
        Route::post( '/run/migrations', 'SetupController@runMigrations' )
            ->name( 'vh.setup.run.migrations' );
        //------------------------------------------------
        Route::any( '/setup/cms', 'SetupController@setupCMS' )
            ->name( 'vh.setup.run.migrations' );
        //------------------------------------------------
        Route::post( '/store/admin', 'SetupController@storeAdmin' )
            ->name( 'vh.setup.store.admin' );
        //------------------------------------------------
        //------------------------------------------------
    });



Route::group(
    [
        'prefix'     => 'admin',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'PublicController@login' )
            ->name( 'vh.admin' );
        //------------------------------------------------
        Route::get( '/login', 'PublicController@redirectToLogin' )
            ->name( 'vh.admin.login' );
        //------------------------------------------------
        Route::post( '/login/post', 'PublicController@postLogin' )
            ->name( 'vh.admin.login.post' );
        //------------------------------------------------
        Route::get( '/logout', 'PublicController@logout' )
            ->name( 'vh.admin.logout' );
        //------------------------------------------------
        //------------------------------------------------
    });



Route::group(
    [
        'prefix'     => 'admin',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/dashboard', 'DashboardController@index' )
            ->name( 'vh.admin.dashboard' );
        //------------------------------------------------
        Route::get( '/layout/app', 'DashboardController@layoutApp' )
            ->name( 'vh.admin.layout.app' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });





Route::group(
    [
        'prefix'     => 'admin/vaah',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'DashboardController@vaah' )
            ->name( 'vh.admin.vaah' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });






Route::group(
    [
        'prefix'     => 'admin/vaah/modules',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'ModuleController@index' )
            ->name( 'vh.admin.modules' );
        //------------------------------------------------
        Route::any( '/assets', 'ModuleController@assets' )
            ->name( 'vh.admin.modules.assets' );
        //------------------------------------------------
        Route::any( '/download', 'ModuleController@download' )
            ->name( 'vh.admin.modules.download' );
        //------------------------------------------------
        Route::any( '/list', 'ModuleController@getList' )
            ->name( 'vh.admin.modules.list' );
        //------------------------------------------------
        Route::any( '/actions', 'ModuleController@actions' )
            ->name( 'vh.admin.modules.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ModuleController@getModulesSlugs' )
            ->name( 'vh.admin.modules.get.slugs' );
        //------------------------------------------------
        Route::any( '/update/versions', 'ModuleController@updateModuleVersions' )
            ->name( 'vh.admin.modules.update.version' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ModuleController@installUpdates' )
            ->name( 'vh.admin.modules.install.updates' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'admin/vaah/themes',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'ThemeController@index' )
            ->name( 'vh.admin.themes' );
        //------------------------------------------------
        Route::any( '/assets', 'ThemeController@assets' )
            ->name( 'vh.admin.themes.assets' );
        //------------------------------------------------
        Route::any( '/download', 'ThemeController@download' )
            ->name( 'vh.admin.themes.download' );
        //------------------------------------------------
        Route::any( '/list', 'ThemeController@getList' )
            ->name( 'vh.admin.themes.list' );
        //------------------------------------------------
        Route::any( '/actions', 'ThemeController@actions' )
            ->name( 'vh.admin.themes.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ThemeController@getModulesSlugs' )
            ->name( 'vh.admin.themes.get.slugs' );
        //------------------------------------------------
        Route::any( '/update/versions', 'ThemeController@updateModuleVersions' )
            ->name( 'vh.admin.themes.update.version' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ThemeController@installUpdates' )
            ->name( 'vh.admin.themes.install.updates' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });



Route::group(
    [
        'prefix'     => 'admin/composer',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/install', 'ComposerController@install' )
            ->name( 'vh.admin.composer.install' );
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'admin/vaah/registrations',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'RegistrationController@index' )
            ->name( 'vh.admin.registrations' );
        //------------------------------------------------
        Route::any( '/assets', 'RegistrationController@assets' )
            ->name( 'vh.admin.registrations.assets' );
        //------------------------------------------------
        Route::any( '/list', 'RegistrationController@getList' )
            ->name( 'vh.admin.registrations.list' );
        //------------------------------------------------
        Route::any( '/actions', 'RegistrationController@actions' )
            ->name( 'vh.admin.registrations.actions' );
        //------------------------------------------------
        Route::any( '/store', 'RegistrationController@store' )
            ->name( 'vh.admin.registrations.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'RegistrationController@getDetails' )
            ->name( 'vh.admin.registrations.view' );
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'admin/vaah/users',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'UserController@index' )
            ->name( 'vh.admin.users' );
        //------------------------------------------------
        Route::any( '/assets', 'UserController@assets' )
            ->name( 'vh.admin.users.assets' );
        //------------------------------------------------
        Route::any( '/list', 'UserController@getList' )
            ->name( 'vh.admin.users.list' );
        //------------------------------------------------
        Route::any( '/actions', 'UserController@actions' )
            ->name( 'vh.admin.users.actions' );
        //------------------------------------------------
        Route::any( '/store', 'UserController@store' )
            ->name( 'vh.admin.users.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'UserController@getDetails' )
            ->name( 'vh.admin.users.view' );
        //------------------------------------------------
        Route::any( '/roles/{id}', 'UserController@getRoles' )
            ->name( 'vh.admin.users.roles' );
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'admin/vaah/roles',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'RoleController@index' )
            ->name( 'vh.admin.roles' );
        //------------------------------------------------
        Route::any( '/assets', 'RoleController@assets' )
            ->name( 'vh.admin.roles.assets' );
        //------------------------------------------------
        Route::any( '/list', 'RoleController@getList' )
            ->name( 'vh.admin.roles.list' );
        //------------------------------------------------
        Route::any( '/actions', 'RoleController@actions' )
            ->name( 'vh.admin.roles.actions' );
        //------------------------------------------------
        Route::any( '/store', 'RoleController@store' )
            ->name( 'vh.admin.roles.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'RoleController@getDetails' )
            ->name( 'vh.admin.roles.view' );
        //------------------------------------------------
        Route::any( '/permissions/{id}', 'RoleController@getPermissions' )
            ->name( 'vh.admin.roles.permissions' );
        //------------------------------------------------
        Route::any( '/users/{id}', 'RoleController@getUsers' )
            ->name( 'vh.admin.roles.users' );
        //------------------------------------------------
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'admin/vaah/permissions',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'PermissionController@index' )
            ->name( 'vh.admin.permissions' );
        //------------------------------------------------
        Route::any( '/assets', 'PermissionController@assets' )
            ->name( 'vh.admin.permissions.assets' );
        //------------------------------------------------
        Route::any( '/list', 'PermissionController@getList' )
            ->name( 'vh.admin.permissions.list' );
        //------------------------------------------------
        Route::any( '/actions', 'PermissionController@actions' )
            ->name( 'vh.admin.permissions.actions' );
        //------------------------------------------------
        Route::any( '/store', 'PermissionController@store' )
            ->name( 'vh.admin.permissions.store' );
        //------------------------------------------------
        Route::any( '/view/{id}', 'PermissionController@getDetails' )
            ->name( 'vh.admin.permissions.view' );
        //------------------------------------------------
        Route::any( '/roles/{id}', 'PermissionController@getRoles' )
            ->name( 'vh.admin.permissions.roles' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
