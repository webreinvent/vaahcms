<?php

/*
 * API url will be: <base-url>/public/api/vaah/batches
 */
Route::group(
    [
        'prefix' => 'api/vaah/batches',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced',
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
     * Delete List
     */
    Route::delete('/', 'BatchesController@deleteList')
        ->name('vh.backend.vaah.api.batches.list.delete');

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
