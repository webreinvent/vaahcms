<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(
    [
        'prefix'     => 'api',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Api',
    ],
    function () {

        Route::group(
            [
                'prefix'     => '/users',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'UsersController@getList' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'UsersController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'UsersController@getItemPermissions' );
                //------------------------------------------------
            });

        Route::group(
            [
                'prefix'     => '/roles',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'RolesController@getList' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'UsersController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'UsersController@getItemPermissions' );
                //------------------------------------------------
            });

        Route::group(
            [
                'prefix'     => '/permissions',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'PermissionsController@getList' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'UsersController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'UsersController@getItemPermissions' );
                //------------------------------------------------
            });

        Route::group(
            [
                'prefix'     => '/registrations',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'RegistrationsController@getList' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'UsersController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'UsersController@getItemPermissions' );
                //------------------------------------------------
            });

        Route::group(
            [
                'prefix'     => '/taxonomies',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'TaxonomiesController@getList' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'UsersController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'UsersController@getItemPermissions' );
                //------------------------------------------------
            });
    });


