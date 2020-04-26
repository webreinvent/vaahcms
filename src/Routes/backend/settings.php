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
        'prefix'     => 'backend/vaah/settings/general',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'GeneralController@getAssets' )
            ->name( 'vh.backend.settings.general.assets' );
        //------------------------------------------------
        Route::any( '/list', 'GeneralController@getList' )
            ->name( 'vh.backend.settings.general.list' );
        //------------------------------------------------
        Route::any( '/store/site/settings', 'GeneralController@storeSiteSettings' )
            ->name( 'vh.backend.settings.general.store.site.settings' );
        //------------------------------------------------
        Route::any( '/store/links', 'GeneralController@storeLinks' )
            ->name( 'vh.backend.settings.general.store.links' );
        //------------------------------------------------
        Route::any( '/store/meta/tags', 'GeneralController@storeMetaTags' )
            ->name( 'vh.backend.settings.general.store.meta.tags' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/settings/env',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'EnvController@getAssets' )
            ->name( 'vh.backend.settings.env.assets' );
        //------------------------------------------------
        Route::any( '/list', 'EnvController@getList' )
            ->name( 'vh.backend.settings.env.list' );
        //------------------------------------------------
        Route::any( '/store', 'EnvController@store' )
            ->name( 'vh.backend.settings.env.store' );
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



Route::group(
    [
        'prefix'     => 'backend/vaah/settings/notifications',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'NotificationsController@getAssets' )
            ->name( 'vh.backend.settings.notifications.assets' );
        //------------------------------------------------
        Route::any( '/list', 'NotificationsController@getList' )
            ->name( 'vh.backend.settings.notifications.list' );
        //------------------------------------------------
        Route::any( '/store', 'NotificationsController@store' )
            ->name( 'vh.backend.settings.notifications.store' );
        //------------------------------------------------
        Route::any( '/content', 'NotificationsController@getContent' )
            ->name( 'vh.backend.settings.notifications.content' );
        //------------------------------------------------
        Route::any( '/send', 'NotificationsController@send' )
            ->name( 'vh.backend.settings.notifications.send' );
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/settings/backups',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/assets', 'BackupsController@getAssets' )
            ->name( 'vh.backend.settings.localization.assets' );
        //------------------------------------------------
        Route::any( '/list', 'BackupsController@getList' )
            ->name( 'vh.backend.settings.localization.list' );
        //------------------------------------------------
        Route::any( '/store', 'BackupsController@store' )
            ->name( 'vh.backend.settings.localization.store' );
        //------------------------------------------------
        Route::any( '/store/language', 'BackupsController@storeLanguage' )
            ->name( 'vh.backend.settings.localization.store.language' );
        //------------------------------------------------
        Route::any( '/store/category', 'BackupsController@storeCategory' )
            ->name( 'vh.backend.settings.localization.store.category' );
        //------------------------------------------------
        Route::any( '/sync', 'BackupsController@sync' )
            ->name( 'vh.backend.settings.localization.sync' );
        //------------------------------------------------
        Route::any( '/delete', 'BackupsController@delete' )
            ->name( 'vh.backend.settings.localization.delete' );
        //------------------------------------------------
        Route::any( '/upload', 'BackupsController@upload' )
            ->name( 'vh.backend.settings.localization.upload' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
