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
    });
