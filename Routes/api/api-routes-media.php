<?php

/*
 * API url will be: <base-url>/public/api/vaah/manage/media
 */
Route::group(
    [
        'prefix' => 'api/vaah/manage/media',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'MediaController@getAssets')
        ->name('vh.backend.vaah.api.media.assets');
    /**
     * Get List
     */
    Route::get('/', 'MediaController@getList')
        ->name('vh.backend.vaah.api.media.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'MediaController@updateList')
        ->name('vh.backend.vaah.api.media.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'MediaController@deleteList')
        ->name('vh.backend.vaah.api.media.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'MediaController@postCreate')
        ->name('vh.backend.vaah.api.media.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'MediaController@getItem')
        ->name('vh.backend.vaah.api.media.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'MediaController@updateItem')
        ->name('vh.backend.vaah.api.media.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'MediaController@deleteItem')
        ->name('vh.backend.vaah.api.media.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'MediaController@listAction')
        ->name('vh.backend.vaah.api.media.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'MediaController@itemAction')
        ->name('vh.backend.vaah.api.media.item.action');

    //---------------------------------------------------------
    Route::post( '/upload', 'MediaController@upload' )
        ->name( 'vh.backend.vaah.api.media.upload' );
    //------------------------------------------------
    Route::post('/downloadable/slug/available', 'MediaController@isDownloadableSlugAvailable')
        ->name('backend.vaah.api.media.downloadable.slug.available');
    //---------------------------------------------------------


});
