<?php

/*
 * API url will be: <base-url>/public/api/vaah/themes
 */
Route::group(
    [
        'prefix' => 'api/vaah/themes',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'ThemesController@getAssets')
        ->name('vh.backend.vaah.api.themes.assets');
    /**
     * Get List
     */
    Route::get('/', 'ThemesController@getList')
        ->name('vh.backend.vaah.api.themes.list');

    /**
     * Get Item
     */
    Route::get('/{id}', 'ThemesController@getItem')
        ->name('vh.backend.vaah.api.themes.read');

    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ThemesController@deleteItem')
        ->name('vh.backend.vaah.api.themes.delete');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ThemesController@actions')
        ->name('vh.backend.vaah.api.themes.item.action');


//---------------------------------------------------------
    /**
     * Theme Download
     */
    Route::post( '/download', 'ThemesController@download' )
        ->name( 'vh.backend.vaah.api.themes.download' );

    //------------------------------------------------
    Route::post( '/store/updates', 'ThemesController@storeUpdates' )
        ->name( 'vh.backend.vaah.api.themes.store.updates' );
    //------------------------------------------------
    Route::post( '/install/updates', 'ThemesController@installUpdates' )
        ->name( 'vh.backend.vaah.api.themes.install.updates' );
    //------------------------------------------------
    Route::any( '/publish/assets', 'ThemesController@publishAssets' )
        ->name( 'vh.setup.publish.assets' );
    //------------------------------------------------
});
