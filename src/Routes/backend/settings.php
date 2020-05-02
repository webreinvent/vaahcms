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
        Route::post( '/assets', 'GeneralController@getAssets' )
            ->name( 'vh.backend.settings.general.assets' );
        //------------------------------------------------
        Route::post( '/list', 'GeneralController@getList' )
            ->name( 'vh.backend.settings.general.list' );
        //------------------------------------------------
        Route::post( '/store/site/settings', 'GeneralController@storeSiteSettings' )
            ->name( 'vh.backend.settings.general.store.site.settings' );
        //------------------------------------------------
        Route::post( '/store/links', 'GeneralController@storeLinks' )
            ->name( 'vh.backend.settings.general.store.links' );
        //------------------------------------------------
        Route::post( '/store/meta/tags', 'GeneralController@storeMetaTags' )
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
        Route::post( '/assets', 'EnvController@getAssets' )
            ->name( 'vh.backend.settings.env.assets' );
        //------------------------------------------------
        Route::post( '/list', 'EnvController@getList' )
            ->name( 'vh.backend.settings.env.list' );
        //------------------------------------------------
        Route::post( '/store', 'EnvController@store' )
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
        //---------------------------------------------------------
        Route::post('/assets', 'LocalizationController@getAssets')
            ->name('backend.vaah.localization.assets');
        //---------------------------------------------------------
        Route::post('/list', 'LocalizationController@getList')
            ->name('backend.vaah.localization.list');
        //---------------------------------------------------------
        Route::post('/generateLanguage', 'LocalizationController@generateLanguage')
            ->name('backend.vaah.localization.generate_language');
        //---------------------------------------------------------
        Route::post('/store', 'LocalizationController@postStore')
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
        'prefix'     => 'backend/vaah/settings/notifications',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::post( '/assets', 'NotificationsController@getAssets' )
            ->name( 'vh.backend.settings.notifications.assets' );
        //------------------------------------------------
        Route::post( '/list', 'NotificationsController@getList' )
            ->name( 'vh.backend.settings.notifications.list' );
        //------------------------------------------------
        Route::post( '/create', 'NotificationsController@createItem' )
            ->name( 'vh.backend.settings.notifications.create' );
        //------------------------------------------------
        Route::post( '/store', 'NotificationsController@store' )
            ->name( 'vh.backend.settings.notifications.store' );
        //------------------------------------------------
        Route::post( '/content', 'NotificationsController@getContent' )
            ->name( 'vh.backend.settings.notifications.content' );
        //------------------------------------------------
        Route::post( '/send', 'NotificationsController@send' )
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
        Route::post( '/assets', 'BackupsController@getAssets' )
            ->name( 'vh.backend.settings.localization.assets' );
        //------------------------------------------------
        Route::post( '/list', 'BackupsController@getList' )
            ->name( 'vh.backend.settings.localization.list' );
        //------------------------------------------------
        Route::post( '/store', 'BackupsController@store' )
            ->name( 'vh.backend.settings.localization.store' );
        //------------------------------------------------
        Route::post( '/store/language', 'BackupsController@storeLanguage' )
            ->name( 'vh.backend.settings.localization.store.language' );
        //------------------------------------------------
        Route::post( '/store/category', 'BackupsController@storeCategory' )
            ->name( 'vh.backend.settings.localization.store.category' );
        //------------------------------------------------
        Route::post( '/sync', 'BackupsController@sync' )
            ->name( 'vh.backend.settings.localization.sync' );
        //------------------------------------------------
        Route::post( '/delete', 'BackupsController@delete' )
            ->name( 'vh.backend.settings.localization.delete' );
        //------------------------------------------------
        Route::post( '/upload', 'BackupsController@upload' )
            ->name( 'vh.backend.settings.localization.upload' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
