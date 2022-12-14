<?php

Route::group(
    [
    'prefix' => 'backend/vaah/jobs',
    
    'middleware' => ['web', 'has.backend.access'],
    
    'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'JobsController@getAssets')
        ->name('vh.backend.vaah.jobs.assets');
    /**
     * Get List
     */
    Route::get('/', 'JobsController@getList')
        ->name('vh.backend.vaah.jobs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'JobsController@updateList')
        ->name('vh.backend.vaah.jobs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'JobsController@deleteList')
        ->name('vh.backend.vaah.jobs.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'JobsController@createItem')
        ->name('vh.backend.vaah.jobs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'JobsController@getItem')
        ->name('vh.backend.vaah.jobs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'JobsController@updateItem')
        ->name('vh.backend.vaah.jobs.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'JobsController@deleteItem')
        ->name('vh.backend.vaah.jobs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'JobsController@listAction')
        ->name('vh.backend.vaah.jobs.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'JobsController@itemAction')
        ->name('vh.backend.vaah.jobs.item.action');

    //---------------------------------------------------------

});
