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
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'GeneralController@getAssets' )
            ->name( 'vh.backend.settings.general.assets' );
        //------------------------------------------------
        Route::get( '/list', 'GeneralController@getList' )
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
        Route::post( '/delete/meta/tag', 'GeneralController@deleteMetaTags' )
            ->name( 'vh.backend.settings.general.delete.meta.tags' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/settings/env',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'EnvController@getAssets' )
            ->name( 'vh.backend.settings.env.assets' );
        //------------------------------------------------
        Route::get( '/list', 'EnvController@getList' )
            ->name( 'vh.backend.settings.env.list' );
        //------------------------------------------------
        Route::get( '/download-file/{file_name}', 'EnvController@downloadFile')
            ->name( 'vh.backend.settings.env.download.file' );;
        //---------------------------------------------------------
        Route::post( '/store', 'EnvController@store' )
            ->name( 'vh.backend.settings.env.store' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/settings/user-setting',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'UserSettingController@getAssets' )
            ->name( 'vh.backend.settings.env.assets' );
        //------------------------------------------------
        Route::get( '/list', 'UserSettingController@getList' )
            ->name( 'vh.backend.settings.env.list' );
        //------------------------------------------------
        Route::post( '/field/store', 'UserSettingController@storeField' )
            ->name( 'vh.backend.settings.env.store.field' );
        //------------------------------------------------
        Route::post( '/custom-field/store', 'UserSettingController@storeCustomField' )
            ->name( 'vh.backend.settings.env.store.custom-field' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend/vaah/settings/localization',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'LocalizationController@getAssets')
            ->name('vh.backend.settings.localization.assets');
        //---------------------------------------------------------
        Route::get('/list', 'LocalizationController@getList')
            ->name('backend.vaah.localization.list');
        //---------------------------------------------------------
        Route::post('/generateLanguage', 'LocalizationController@generateLanguage')
            ->name('backend.vaah.localization.generate_language');
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
        'prefix'     => 'backend/vaah/settings/notifications',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'NotificationsController@getAssets' )
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
        'prefix'     => 'backend/vaah/settings/update',
        'middleware' => ['web', 'app.is.installed', 'has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Settings'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::any( '/store', 'UpdateController@storeUpdate' )
            ->name( 'vh.update.store' );
        //------------------------------------------------
        Route::any( '/upgrade', 'UpdateController@upgrade' )
            ->name( 'vh.update.upgrade' );
        //------------------------------------------------
        Route::any( '/publish', 'UpdateController@publish' )
            ->name( 'vh.update.publish' );
        //------------------------------------------------
        Route::any( '/run/migrations', 'UpdateController@runMigrations' )
            ->name( 'vh.update.run.migrations' );
        //------------------------------------------------
        Route::any( '/cache', 'UpdateController@clearCache' )
            ->name( 'vh.update.cache' );
        //------------------------------------------------
    });
