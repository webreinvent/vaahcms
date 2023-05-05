<?php

Route::group(
    [
        'prefix'     => 'vaahcms/setup',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {

        //------------------------------------------------
        Route::get( '/', 'SetupController@index' )
            ->name( 'vh.setup' );
        //------------------------------------------------
    });


/*
|--------------------------------------------------------------------------
| Setup Routes - Public Routes
|--------------------------------------------------------------------------
|
|
*/
Route::group(
    [
        'prefix'     => 'backend/setup/json',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {

        //------------------------------------------------
        Route::get( '/assets', 'SetupController@getAssets' )
            ->name( 'vh.setup.assets' );
        //------------------------------------------------
        Route::get( '/status', 'SetupController@appSetupStatus' )
            ->name( 'vh.setup.status' );
        //------------------------------------------------
    });


/*
|--------------------------------------------------------------------------
| Setup Routes - Access if VaahCMS is not installed
|--------------------------------------------------------------------------
|
| These routes can be accessed only if VaahCMS is not installed.
|
*/
Route::group(
    [
        'prefix'     => 'backend/setup',
        'middleware' => ['web', 'app.is.not.installed'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {

        //------------------------------------------------
        Route::post( '/test/database/connection', 'SetupController@testDBConnection' )
            ->name( 'vh.setup.test.database' );
        //------------------------------------------------
        Route::post( '/test/mail/configuration', 'SetupController@sendTestEmail' )
            ->name( 'vh.setup.mail.configuration' );
        //------------------------------------------------
        Route::post( '/test/configurations', 'SetupController@testConfigurations' )
            ->name( 'vh.setup.configurations' );
        //------------------------------------------------
        Route::post( '/get/configurations', 'SetupController@getConfigurations' )
            ->name( 'vh.setup.get.configurations' );
        //------------------------------------------------
        Route::post( '/required/configurations', 'SetupController@getRequiredConfigurations' )
            ->name( 'vh.setup.get.required.configurations' );
        //------------------------------------------------
        Route::get( '/get/dependencies', 'SetupController@getDependencies' )
            ->name( 'vh.setup.get.dependencies' );
        //------------------------------------------------
        Route::post( '/install/dependencies', 'SetupController@installDependencies' )
            ->name( 'vh.setup.install.dependencies' );
        //------------------------------------------------
        Route::post( '/run/migrations', 'SetupController@runMigrations' )
            ->name( 'vh.setup.run.migrations' );
        //------------------------------------------------
        Route::post( '/store/admin', 'SetupController@storeAdmin' )
            ->name( 'vh.setup.store.backend' );
        //------------------------------------------------
        //------------------------------------------------
    });

/*
|--------------------------------------------------------------------------
| Setup Routes - Access if VaahCMS is installed
|--------------------------------------------------------------------------
|
| These routes can be accessed only if VaahCMS is installed.
|
*/
Route::group(
    [
        'prefix'     => 'backend/setup',
        'middleware' => ['web',  'app.is.installed'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::post( '/reset/confirm', 'SetupController@resetConfirm' )
            ->name( 'vh.setup.reset.confirm' );
        //------------------------------------------------
        Route::any( '/clear/cache', 'SetupController@clearCache' )
            ->name( 'vh.setup.clear.cache' );
        //------------------------------------------------
        Route::any( '/publish/assets', 'SetupController@publishAssets' )
            ->name( 'vh.setup.publish.assets' );
        //------------------------------------------------
        //------------------------------------------------
    });

