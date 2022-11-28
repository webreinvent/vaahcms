<?php

/*
 * API url will be: <base-url>/public/api/vaah/permissions
 */
Route::group(
    [
        'prefix' => 'vaah/permissions',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'PermissionsController@getAssets')
        ->name('vh.backend.vaah.api.permissions.assets');
    /**
     * Get List
     */
    Route::get('/', 'PermissionsController@getList')
        ->name('vh.backend.vaah.api.permissions.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'PermissionsController@updateList')
        ->name('vh.backend.vaah.api.permissions.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'PermissionsController@deleteList')
        ->name('vh.backend.vaah.api.permissions.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'PermissionsController@createItem')
        ->name('vh.backend.vaah.api.permissions.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'PermissionsController@getItem')
        ->name('vh.backend.vaah.api.permissions.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'PermissionsController@updateItem')
        ->name('vh.backend.vaah.api.permissions.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'PermissionsController@deleteItem')
        ->name('vh.backend.vaah.api.permissions.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'PermissionsController@listAction')
        ->name('vh.backend.vaah.api.permissions.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'PermissionsController@itemAction')
        ->name('vh.backend.vaah.api.permissions.item.action');

    /**
     * Get Item Roles
     */
    Route::get('/item/{id}/roles', 'PermissionsController@getItemRoles')
        ->name('backend.vaah.permissions.role');

});
