<?php

/*
 * API url will be: <base-url>/public/api/vaah/medias
 */
Route::group(
    [
        'prefix' => 'vaah/medias',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'MediasController@getAssets')
        ->name('vh.backend.vaah.api.medias.assets');
    /**
     * Get List
     */
    Route::get('/', 'MediasController@getList')
        ->name('vh.backend.vaah.api.medias.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'MediasController@updateList')
        ->name('vh.backend.vaah.api.medias.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'MediasController@deleteList')
        ->name('vh.backend.vaah.api.medias.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'MediasController@createItem')
        ->name('vh.backend.vaah.api.medias.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'MediasController@getItem')
        ->name('vh.backend.vaah.api.medias.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'MediasController@updateItem')
        ->name('vh.backend.vaah.api.medias.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'MediasController@deleteItem')
        ->name('vh.backend.vaah.api.medias.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'MediasController@listAction')
        ->name('vh.backend.vaah.api.medias.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'MediasController@itemAction')
        ->name('vh.backend.vaah.api.medias.item.action');



});
