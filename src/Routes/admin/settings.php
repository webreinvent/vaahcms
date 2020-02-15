<?php


Route::group(
    [
        'prefix'     => 'admin/settings',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'SettingsController@index' )
            ->name( 'vh.admin.settings' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'admin/vaah/settings/localization',
        'middleware' => ['web','has.admin.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'LocalizationController@getAssets' )
            ->name( 'vh.admin.settings.localization.assets' );
        //------------------------------------------------
        Route::any( '/list', 'LocalizationController@getList' )
            ->name( 'vh.admin.settings.localization.list' );
        //------------------------------------------------
        Route::any( '/store', 'LocalizationController@store' )
            ->name( 'vh.admin.settings.localization.store' );
        //------------------------------------------------
        Route::any( '/store/language', 'LocalizationController@storeLanguage' )
            ->name( 'vh.admin.settings.localization.store.language' );
        //------------------------------------------------
        Route::any( '/store/category', 'LocalizationController@storeCategory' )
            ->name( 'vh.admin.settings.localization.store.category' );
        //------------------------------------------------
        Route::any( '/sync', 'LocalizationController@sync' )
            ->name( 'vh.admin.settings.localization.sync' );
        //------------------------------------------------
        Route::any( '/delete', 'LocalizationController@delete' )
            ->name( 'vh.admin.settings.localization.delete' );
        //------------------------------------------------
        Route::any( '/upload', 'LocalizationController@upload' )
            ->name( 'vh.admin.settings.localization.upload' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
