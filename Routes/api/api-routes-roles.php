<?php

/*
 * API url will be: <base-url>/public/api/role/roles
 */
Route::group(
    [
        'prefix' => 'vaah/roles',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'RolesController@getAssets')
        ->name('vh.backend.role.api.roles.assets');
    /**
     * Get List
     */
    Route::get('/', 'RolesController@getList')
        ->name('vh.backend.role.api.roles.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'RolesController@updateList')
        ->name('vh.backend.role.api.roles.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'RolesController@deleteList')
        ->name('vh.backend.role.api.roles.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'RolesController@createItem')
        ->name('vh.backend.role.api.roles.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'RolesController@getItem')
        ->name('vh.backend.role.api.roles.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'RolesController@updateItem')
        ->name('vh.backend.role.api.roles.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'RolesController@deleteItem')
        ->name('vh.backend.role.api.roles.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'RolesController@listAction')
        ->name('vh.backend.role.api.roles.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'RolesController@itemAction')
        ->name('vh.backend.role.api.roles.item.action');



});
