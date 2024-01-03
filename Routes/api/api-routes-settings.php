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

Route::group(
    [
        'prefix'     => 'api/vaah/settings/localization',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'LocalizationController@getAssets')
            ->name('vh.backend.vaah.api.settings.localization.assets');
        //---------------------------------------------------------
        Route::get('/list', 'LocalizationController@getList')
            ->name('api.vaah.localization.list');
        //---------------------------------------------------------
        Route::post('/generateLanguage', 'LocalizationController@generateLanguage')
            ->name('api.vaah.localization.generate_language');
        //---------------------------------------------------------
        Route::post('/store', 'LocalizationController@postStore');
        //---------------------------------------------------------
        Route::post('/store/language', 'LocalizationController@storeLanguage');
        //---------------------------------------------------------
        Route::post('/store/category', 'LocalizationController@storeCategory');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'LocalizationController@postActions');
        //---------------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'api/vaah/settings/notifications',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        Route::get('/', 'NotificationsController@getList')
            ->name('vh.backend.vaah.api.settings.notifications.list');
        //-------------------------------------------------
        Route::any('/action/{action}', 'NotificationsController@listAction')
            ->name('vh.backend.vaah.api.settings.notifications.list.action');
        //------------------------------------------------
        Route::get('/assets', 'NotificationsController@getAssets')
            ->name('vh.backend.vaah.api.settings.notifications.assets');
        //------------------------------------------------
        Route::post('/get-item', 'NotificationsController@getItemData')
            ->name('vh.backend.vaah.api.settings.notifications.getItemData');
        //------------------------------------------------
        Route::post('/create', 'NotificationsController@createItem')
            ->name('vh.backend.vaah.api.settings.notifications.create');
        //------------------------------------------------
        Route::post('/store', 'NotificationsController@store')
            ->name('vh.backend.vaah.api.settings.notifications.store');
        //------------------------------------------------
        Route::post('/send', 'NotificationsController@send')
            ->name('vh.backend.vaah.api.settings.notifications.send');
        //------------------------------------------------
        Route::match(['put', 'delete'], '/{id}/action/{type}', 'NotificationsController@itemAction')
            ->name('vh.backend.vaah.api.settings.notifications.item.action');

        //---------------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'api/vaah/settings/backups',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::post( '/assets', 'BackupsController@getAssets' )
            ->name( 'vh.backend.vaah.api.settings.localization.assets' );
        //------------------------------------------------
        Route::post( '/list', 'BackupsController@getList' )
            ->name( 'vh.backend.vaah.api.settings.localization.list' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });



/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
|
| These routes can be accessed only if VaahCMS is installed.
|
*/
Route::group(
    [
        'prefix'     => 'api/vaah/settings/update',
        'middleware' => ['auth:api', 'app.is.installed'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::any( '/store', 'UpdateController@storeUpdate' )
            ->name( 'vh.update.api.store' );
        //------------------------------------------------
        Route::any( '/upgrade', 'UpdateController@upgrade' )
            ->name( 'vh.update.api.upgrade' );
        //------------------------------------------------
        Route::any( '/publish', 'UpdateController@publish' )
            ->name( 'vh.update.api.publish' );
        //------------------------------------------------
        Route::any( '/run/migrations', 'UpdateController@runMigrations' )
            ->name( 'vh.update.api.run.migrations' );
        //------------------------------------------------
        Route::any( '/cache', 'UpdateController@clearCache' )
            ->name( 'vh.update.api.cache' );
        //------------------------------------------------
    });


