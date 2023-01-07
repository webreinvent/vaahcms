<?php

Route::group(
    [
        'prefix' => 'backend/vaah/logs',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'LogsController@getAssets')
        ->name('vh.backend.vaah.jobs.assets');
    /**
     * Get List
     */
    Route::get('/', 'LogsController@getList')
        ->name('vh.backend.vaah.jobs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'LogsController@updateList')
        ->name('vh.backend.vaah.jobs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'LogsController@deleteList')
        ->name('vh.backend.vaah.jobs.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'LogsController@createItem')
        ->name('vh.backend.vaah.jobs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'LogsController@getItem')
        ->name('vh.backend.vaah.jobs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'LogsController@updateItem')
        ->name('vh.backend.vaah.jobs.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'LogsController@deleteItem')
        ->name('vh.backend.vaah.jobs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'LogsController@listAction')
        ->name('vh.backend.vaah.jobs.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'LogsController@itemAction')
        ->name('vh.backend.vaah.jobs.item.action');

    //---------------------------------------------------------

});
