<?php

Route::group(
    [
        'prefix' => 'backend/vaah/modules',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'WebReinvent\VaahCms\Http\Controllers',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'ModulesController@getAssets')
        ->name('vh.backend.vaah.modules.assets');
    /**
     * Get List
     */
    Route::get('/', 'ModulesController@getList')
        ->name('vh.backend.vaah.modules.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ModulesController@updateList')
        ->name('vh.backend.vaah.modules.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ModulesController@deleteList')
        ->name('vh.backend.vaah.modules.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'ModulesController@createItem')
        ->name('vh.backend.vaah.modules.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ModulesController@getItem')
        ->name('vh.backend.vaah.modules.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ModulesController@updateItem')
        ->name('vh.backend.vaah.modules.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ModulesController@deleteItem')
        ->name('vh.backend.vaah.modules.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ModulesController@listAction')
        ->name('vh.backend.vaah.modules.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ModulesController@actions')
        ->name('vh.backend.vaah.modules.item.action');

    //---------------------------------------------------------

});
