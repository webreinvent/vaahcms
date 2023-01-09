<?php

Route::group(
    [
        'prefix' => 'backend/vaah/batches',
        
        'middleware' => ['web', 'has.backend.access'],
        
        'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'BatchesController@getAssets')
        ->name('vh.backend.vaah.batches.assets');
    /**
     * Get List
     */
    Route::get('/', 'BatchesController@getList')
        ->name('vh.backend.vaah.batches.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'BatchesController@updateList')
        ->name('vh.backend.vaah.batches.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'BatchesController@deleteList')
        ->name('vh.backend.vaah.batches.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'BatchesController@createItem')
        ->name('vh.backend.vaah.batches.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'BatchesController@getItem')
        ->name('vh.backend.vaah.batches.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'BatchesController@updateItem')
        ->name('vh.backend.vaah.batches.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'BatchesController@deleteItem')
        ->name('vh.backend.vaah.batches.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'BatchesController@listAction')
        ->name('vh.backend.vaah.batches.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'BatchesController@itemAction')
        ->name('vh.backend.vaah.batches.item.action');

    //---------------------------------------------------------

});
