<?php

Route::group(
    [
        'prefix'     => 'api/settings',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'SettingsController@index' )
            ->name( 'vh.backend.api.settings' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'api/vaah/settings/general',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'GeneralController@getAssets' )
            ->name( 'vh.backend.vaah.api.settings.general.assets' );
        //------------------------------------------------
        Route::get( '/list', 'GeneralController@getList' )
            ->name( 'vh.backend.vaah.api.settings.general.list' );
        //------------------------------------------------
        Route::post( '/store/site/settings', 'GeneralController@storeSiteSettings' )
            ->name( 'vh.backend.vaah.api.settings.general.store.site.settings' );
        //------------------------------------------------
        Route::post( '/store/links', 'GeneralController@storeLinks' )
            ->name( 'vh.backend.vaah.api.settings.general.store.links' );
        //------------------------------------------------
        Route::post( '/store/meta/tags', 'GeneralController@storeMetaTags' )
            ->name( 'vh.backend.vaah.api.settings.general.store.meta.tags' );
        Route::post( '/delete/meta/tag', 'GeneralController@deleteMetaTags' )
            ->name( 'vh.backend.vaah.api.settings.general.delete.meta.tags' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'api/vaah/settings/env',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'EnvController@getAssets' )
            ->name( 'vh.backend.vaah.api.settings.env.assets' );
        //------------------------------------------------
        Route::get( '/list', 'EnvController@getList' )
            ->name( 'vh.backend.vaah.api.settings.env.list' );
        //------------------------------------------------
        Route::get( '/download-file/{file_name}', 'EnvController@downloadFile')
            ->name( 'vh.backend.vaah.api.settings.env.download.file' );;
        //---------------------------------------------------------
        Route::post( '/store', 'EnvController@store' )
            ->name( 'vh.backend.vaah.api.settings.env.store' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'api/vaah/settings/user-setting',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'UserSettingController@getAssets' )
            ->name( 'vh.backend.vaah.api.settings.env.assets' );
        //------------------------------------------------
        Route::get( '/list', 'UserSettingController@getList' )
            ->name( 'vh.backend.vaah.api.settings.env.list' );
        //------------------------------------------------
        Route::post( '/field/store', 'UserSettingController@storeField' )
            ->name( 'vh.backend.vaah.api.settings.env.store.field' );
        //------------------------------------------------
        Route::post( '/custom-field/store', 'UserSettingController@storeCustomField' )
            ->name( 'vh.backend.vaah.api.settings.env.store.custom-field' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
