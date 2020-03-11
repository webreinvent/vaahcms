<?php


Route::group(
    [
        'prefix'     => 'backend/settings',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'SettingsController@index' )
            ->name( 'vh.backend.settings' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/settings/localization',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'LocalizationController@getAssets' )
            ->name( 'vh.backend.settings.localization.assets' );
        //------------------------------------------------
        Route::any( '/list', 'LocalizationController@getList' )
            ->name( 'vh.backend.settings.localization.list' );
        //------------------------------------------------
        Route::any( '/store', 'LocalizationController@store' )
            ->name( 'vh.backend.settings.localization.store' );
        //------------------------------------------------
        Route::any( '/store/language', 'LocalizationController@storeLanguage' )
            ->name( 'vh.backend.settings.localization.store.language' );
        //------------------------------------------------
        Route::any( '/store/category', 'LocalizationController@storeCategory' )
            ->name( 'vh.backend.settings.localization.store.category' );
        //------------------------------------------------
        Route::any( '/sync', 'LocalizationController@sync' )
            ->name( 'vh.backend.settings.localization.sync' );
        //------------------------------------------------
        Route::any( '/delete', 'LocalizationController@delete' )
            ->name( 'vh.backend.settings.localization.delete' );
        //------------------------------------------------
        Route::any( '/upload', 'LocalizationController@upload' )
            ->name( 'vh.backend.settings.localization.upload' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
