<?php

/*
 * API url will be: <base-url>/public/api/vaah/failedjobs
 */
Route::group(
    [
        'prefix' => 'vaah/failedjobs',
        'namespace' => 'Backend',
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
     * Create Item
     */
    Route::post('/', 'FailedJobsController@createItem')
        ->name('vh.backend.vaah.api.failedjobs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'FailedJobsController@getItem')
        ->name('vh.backend.vaah.api.failedjobs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'FailedJobsController@updateItem')
        ->name('vh.backend.vaah.api.failedjobs.update');
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

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'FailedJobsController@itemAction')
        ->name('vh.backend.vaah.api.failedjobs.item.action');



});
