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
        Route::post( '/post', 'PublicController@postLogin' )
            ->name( 'vh.admin.login.post' );
        //------------------------------------------------
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
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });