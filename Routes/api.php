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
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Api',
    ],
    function () {

        Route::post( '/signin', 'AuthController@postSignIn' );
        //------------------------------------------------
        Route::post( '/signup', 'AuthController@postSignUp' );
        //------------------------------------------------
        Route::any( '/disable/mfa/{api_token}', 'PublicController@disableMfa' )
            ->name( 'vh.backend.disable.mfa' );
    });

Route::group(
    [
        'prefix'     => 'api',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Api',
    ],
    function () {

        Route::group(
            [
                'prefix'     => '/registrations',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'RegistrationsController@getList' );
                //------------------------------------------------
                Route::any( '/create', 'RegistrationsController@create' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'RegistrationsController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/update', 'RegistrationsController@update' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/delete', 'RegistrationsController@delete' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/create-user', 'RegistrationsController@createUser' );
                //------------------------------------------------
            });

        Route::group(
            [
                'prefix'     => '/users',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'UsersController@getList' );
                //------------------------------------------------
                Route::any( '/create', 'UsersController@create' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'UsersController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/update', 'UsersController@update' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/delete', 'UsersController@delete' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles/{role_slug}', 'UsersController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'UsersController@getItemPermissions' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions/{permission_slug}', 'UsersController@getItemPermissions' );
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
                Route::any( '/create', 'RolesController@create' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'RolesController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/update', 'RolesController@update' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/delete', 'RolesController@delete' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/users', 'RolesController@getItemUsers' );

                //------------------------------------------------
                Route::any( '/{column}/{value}/permissions', 'RolesController@getItemPermissions' );
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
                Route::any( '/{column}/{value}', 'PermissionsController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/roles', 'PermissionsController@getItemRoles' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/users', 'PermissionsController@getItemUsers' );
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
                Route::any( '/create', 'TaxonomiesController@create' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'TaxonomiesController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/update', 'TaxonomiesController@update' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/delete', 'TaxonomiesController@delete' );

            });


        Route::group(
            [
                'prefix'     => '/taxonomy-types',
            ],
            function () {
                //------------------------------------------------
                Route::any( '/', 'TaxonomyTypesController@getList' );
                //------------------------------------------------
                Route::any( '/create', 'TaxonomyTypesController@create' );
                //------------------------------------------------
                Route::any( '/{column}/{value}', 'TaxonomyTypesController@getItem' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/update', 'TaxonomyTypesController@update' );
                //------------------------------------------------
                Route::any( '/{column}/{value}/delete', 'TaxonomyTypesController@delete' );
            });
    });


