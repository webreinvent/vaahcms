<?php

/*
 * API url will be: <base-url>/public/api/vaah/taxonomiescontroller
 */
Route::group(
    [
        'prefix' => 'vaah/taxonomiescontroller',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'TaxonomiesControllerController@getAssets')
        ->name('vh.backend.vaah.api.taxonomiescontroller.assets');
    /**
     * Get List
     */
    Route::get('/', 'TaxonomiesControllerController@getList')
        ->name('vh.backend.vaah.api.taxonomiescontroller.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'TaxonomiesControllerController@updateList')
        ->name('vh.backend.vaah.api.taxonomiescontroller.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'TaxonomiesControllerController@deleteList')
        ->name('vh.backend.vaah.api.taxonomiescontroller.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'TaxonomiesControllerController@createItem')
        ->name('vh.backend.vaah.api.taxonomiescontroller.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'TaxonomiesControllerController@getItem')
        ->name('vh.backend.vaah.api.taxonomiescontroller.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'TaxonomiesControllerController@updateItem')
        ->name('vh.backend.vaah.api.taxonomiescontroller.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'TaxonomiesControllerController@deleteItem')
        ->name('vh.backend.vaah.api.taxonomiescontroller.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'TaxonomiesControllerController@listAction')
        ->name('vh.backend.vaah.api.taxonomiescontroller.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'TaxonomiesControllerController@itemAction')
        ->name('vh.backend.vaah.api.taxonomiescontroller.item.action');



});
