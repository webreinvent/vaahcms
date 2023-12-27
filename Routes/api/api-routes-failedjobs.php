<?php

/*
 * API url will be: <base-url>/public/api/vaah/failedjobs
 */
Route::group(
    [
        'prefix' => 'api/vaah/failedjobs',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'FailedJobsController@getAssets')
        ->name('vh.backend.vaah.api.failedjobs.assets');
    /**
     * Get List
     */
    Route::get('/', 'FailedJobsController@getList')
        ->name('vh.backend.vaah.api.failedjobs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'FailedJobsController@updateList')
        ->name('vh.backend.vaah.api.failedjobs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'FailedJobsController@deleteList')
        ->name('vh.backend.vaah.api.failedjobs.list.delete');

    /**
     * Delete Item
     */
    Route::delete('/{id}', 'FailedJobsController@deleteItem')
        ->name('vh.backend.vaah.api.failedjobs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'FailedJobsController@listAction')
        ->name('vh.backend.vaah.api.failedjobs.list.action');

});
