<?php

/*
 * API url will be: <base-url>/public/api/vaah/jobs
 */
Route::group(
    [
        'prefix' => 'vaah/jobs',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'JobsController@getAssets')
        ->name('vh.backend.vaah.api.jobs.assets');
    /**
     * Get List
     */
    Route::get('/', 'JobsController@getList')
        ->name('vh.backend.vaah.api.jobs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'JobsController@updateList')
        ->name('vh.backend.vaah.api.jobs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'JobsController@deleteList')
        ->name('vh.backend.vaah.api.jobs.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'JobsController@createItem')
        ->name('vh.backend.vaah.api.jobs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'JobsController@getItem')
        ->name('vh.backend.vaah.api.jobs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'JobsController@updateItem')
        ->name('vh.backend.vaah.api.jobs.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'JobsController@deleteItem')
        ->name('vh.backend.vaah.api.jobs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'JobsController@listAction')
        ->name('vh.backend.vaah.api.jobs.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'JobsController@itemAction')
        ->name('vh.backend.vaah.api.jobs.item.action');



});
