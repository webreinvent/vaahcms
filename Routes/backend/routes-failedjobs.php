<?php

Route::group(
    [
        'prefix' => 'backend/vaah/failedjobs',
        
        'middleware' => ['web', 'has.backend.access'],
        
        'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'FailedJobsController@getAssets')
        ->name('vh.backend.vaah.failedjobs.assets');
    /**
     * Get List
     */
    Route::get('/', 'FailedJobsController@getList')
        ->name('vh.backend.vaah.failedjobs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'FailedJobsController@updateList')
        ->name('vh.backend.vaah.failedjobs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'FailedJobsController@deleteList')
        ->name('vh.backend.vaah.failedjobs.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'FailedJobsController@createItem')
        ->name('vh.backend.vaah.failedjobs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'FailedJobsController@getItem')
        ->name('vh.backend.vaah.failedjobs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'FailedJobsController@updateItem')
        ->name('vh.backend.vaah.failedjobs.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'FailedJobsController@deleteItem')
        ->name('vh.backend.vaah.failedjobs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'FailedJobsController@listAction')
        ->name('vh.backend.vaah.failedjobs.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'FailedJobsController@itemAction')
        ->name('vh.backend.vaah.failedjobs.item.action');

    //---------------------------------------------------------

});
