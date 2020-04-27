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
include('backend/registrations.php');
include('backend/profile.php');
include('backend/localization.php');

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
