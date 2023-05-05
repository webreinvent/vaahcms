<?php

/*
 * API url will be: <base-url>/public/api/vaah/media
 */
Route::group(
    [
        'prefix' => 'vaah/media',
        'namespace' => 'Backend',
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
    Route::post('/', 'MediaController@createItem')
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



});
