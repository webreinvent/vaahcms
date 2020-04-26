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
include('backend/modules.php');
include('backend/themes.php');
include('backend/media.php');

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

        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/json',
        'middleware' => ['web', 'has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/users/{name?}', 'JsonController@getUsers' )
            ->name( 'vh.backend.json.users' );
        //------------------------------------------------

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

Route::group(
    [
        'prefix' => 'backend/vaah/profile',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::post('/', 'UsersController@getProfile')
            ->name('backend.vaah.profile');
        //---------------------------------------------------------
        Route::post('/assets', 'UsersController@getAssets')
            ->name('backend.vaah.profile.assets');
        //---------------------------------------------------------
        Route::post('/store', 'UsersController@storeProfile')
            ->name('backend.vaah.profile.store');
        //---------------------------------------------------------
        Route::post('/store/password', 'UsersController@storeProfilePassword')
            ->name('backend.vaah.profile.store.password');
        //---------------------------------------------------------
        Route::post('/avatar/store', 'UsersController@storeProfileAvatar')
            ->name('backend.vaah.profile.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'UsersController@removeProfileAvatar')
            ->name('backend.vaah.profile.avatar.remove');
        //---------------------------------------------------------
    });



Route::group(
    [
        'prefix' => 'backend/vaah/settings/localization',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'LocalizationController@getAssets')
            ->name('backend.vaah.localization.assets');
        //---------------------------------------------------------
        Route::post('/list', 'LocalizationController@getList')
            ->name('backend.vaah.localization.list');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'LocalizationController@postStore')
            ->name('backend.vaah.localization.store');
        //---------------------------------------------------------
        Route::post('/store/language', 'LocalizationController@storeLanguage')
            ->name('backend.vaah.localization.store');
        //---------------------------------------------------------
        Route::post('/store/category', 'LocalizationController@storeCategory')
            ->name('backend.vaah.localization.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'LocalizationController@postActions')
            ->name('backend.vaah.localization.actions');
        //---------------------------------------------------------
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
        Route::post('/avatar/store', 'UsersController@storeAvatar')
            ->name('backend.vaah.users.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'UsersController@removeAvatar')
            ->name('backend.vaah.users.avatar.remove');
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
        'prefix'     => 'backend/vaah/roles',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
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
