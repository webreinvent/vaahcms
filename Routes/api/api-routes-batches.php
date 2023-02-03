<?php

/*
 * API url will be: <base-url>/public/api/vaah/batches
 */
Route::group(
    [
        'prefix' => 'vaah/batches',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'BatchesController@getAssets')
        ->name('vh.backend.vaah.api.batches.assets');
    /**
     * Get List
     */
    Route::get('/', 'BatchesController@getList')
        ->name('vh.backend.vaah.api.batches.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'BatchesController@updateList')
        ->name('vh.backend.vaah.api.batches.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'BatchesController@deleteList')
        ->name('vh.backend.vaah.api.batches.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'BatchesController@createItem')
        ->name('vh.backend.vaah.api.batches.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'BatchesController@getItem')
        ->name('vh.backend.vaah.api.batches.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'BatchesController@updateItem')
        ->name('vh.backend.vaah.api.batches.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'BatchesController@deleteItem')
        ->name('vh.backend.vaah.api.batches.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'BatchesController@listAction')
        ->name('vh.backend.vaah.api.batches.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'BatchesController@itemAction')
        ->name('vh.backend.vaah.api.batches.item.action');



});
