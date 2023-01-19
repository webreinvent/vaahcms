<?php

/*
 * API url will be: <base-url>/public/api/vaah/modules
 */
Route::group(
    [
        'prefix' => 'vaah/modules',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'ModulesController@getAssets')
        ->name('vh.backend.vaah.api.modules.assets');
    /**
     * Get List
     */
    Route::get('/', 'ModulesController@getList')
        ->name('vh.backend.vaah.api.modules.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ModulesController@updateList')
        ->name('vh.backend.vaah.api.modules.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ModulesController@deleteList')
        ->name('vh.backend.vaah.api.modules.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'ModulesController@createItem')
        ->name('vh.backend.vaah.api.modules.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ModulesController@getItem')
        ->name('vh.backend.vaah.api.modules.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ModulesController@updateItem')
        ->name('vh.backend.vaah.api.modules.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ModulesController@deleteItem')
        ->name('vh.backend.vaah.api.modules.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ModulesController@listAction')
        ->name('vh.backend.vaah.api.modules.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ModulesController@itemAction')
        ->name('vh.backend.vaah.api.modules.item.action');



});
