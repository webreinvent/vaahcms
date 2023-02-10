<?php

Route::group(
    [
        'prefix' => 'backend/vaah/manage/media',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'MediaController@getAssets')
        ->name('vh.backend.vaah.media.assets');
    /**
     * Get List
     */
    Route::get('/', 'MediaController@getList')
        ->name('vh.backend.vaah.media.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'MediaController@updateList')
        ->name('vh.backend.vaah.media.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'MediaController@deleteList')
        ->name('vh.backend.vaah.media.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'MediaController@postCreate')
        ->name('vh.backend.vaah.media.create');

    /**
     * Get Item
     */
    Route::get('/{id}', 'MediaController@getItem')
        ->name('vh.backend.vaah.media.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'MediaController@updateItem')
        ->name('vh.backend.vaah.media.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'MediaController@deleteItem')
        ->name('vh.backend.vaah.media.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'MediaController@listAction')
        ->name('vh.backend.vaah.media.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'MediaController@itemAction')
        ->name('vh.backend.vaah.media.item.action');

    //---------------------------------------------------------
    Route::post( '/upload', 'MediaController@upload' )
        ->name( 'vh.backend.media.upload' );
    //------------------------------------------------
    Route::post('/downloadable/slug/available', 'MediaController@isDownloadableSlugAvailable')
        ->name('backend.vaah.media.downloadable.slug.available');
    //---------------------------------------------------------

});
