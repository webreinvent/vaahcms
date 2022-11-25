<?php

Route::group(
    [
    'prefix' => 'backend/vaah/permissions',
    
    'middleware' => ['web', 'has.backend.access'],
    
    'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'PermissionsController@getAssets')
        ->name('vh.backend.vaah.permissions.assets');
    /**
     * Get List
     */
    Route::get('/', 'PermissionsController@getList')
        ->name('vh.backend.vaah.permissions.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'PermissionsController@updateList')
        ->name('vh.backend.vaah.permissions.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'PermissionsController@deleteList')
        ->name('vh.backend.vaah.permissions.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'PermissionsController@createItem')
        ->name('vh.backend.vaah.permissions.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'PermissionsController@getItem')
        ->name('vh.backend.vaah.permissions.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'PermissionsController@updateItem')
        ->name('vh.backend.vaah.permissions.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'PermissionsController@deleteItem')
        ->name('vh.backend.vaah.permissions.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'PermissionsController@listAction')
        ->name('vh.backend.vaah.permissions.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'PermissionsController@itemAction')
        ->name('vh.backend.vaah.permissions.item.action');

    //---------------------------------------------------------

});
