<?php

Route::group(
    [
        'prefix' => 'backend/vaah/themes',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'ThemesController@getAssets')
        ->name('vh.backend.vaah.themes.assets');
    /**
     * Get List
     */
    Route::get('/', 'ThemesController@getList')
        ->name('vh.backend.vaah.themes.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ThemesController@updateList')
        ->name('vh.backend.vaah.themes.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ThemesController@deleteList')
        ->name('vh.backend.vaah.themes.list.delete');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ThemesController@getItem')
        ->name('vh.backend.vaah.modules.read');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ThemesController@deleteItem')
        ->name('vh.backend.vaah.themes.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ThemesController@listAction')
        ->name('vh.backend.vaah.themes.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ThemesController@actions')
        ->name('vh.backend.vaah.themes.item.action');
    //---------------------------------------------------------
    /**
     * Theme Download
     */
    Route::post( '/download', 'ThemesController@download' )
        ->name( 'vh.backend.themes.download' );

    //------------------------------------------------
    Route::post( '/get/slugs', 'ThemesController@ThemesSlugs' )
        ->name( 'vh.backend.themes.get.slugs' );
    //------------------------------------------------
    Route::post( '/store/updates', 'ThemesController@storeUpdates' )
        ->name( 'vh.backend.themes.store.updates' );
    //------------------------------------------------
    Route::post( '/install/updates', 'ThemesController@installUpdates' )
        ->name( 'vh.backend.themes.install.updates' );
    //------------------------------------------------
    Route::any( '/publish/assets', 'ThemesController@publishAssets' )
        ->name( 'vh.setup.publish.assets' );
    //------------------------------------------------

});
