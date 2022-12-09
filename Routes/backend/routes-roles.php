<?php

Route::group(
    [
    'prefix' => 'backend/vaah/roles',

    'middleware' => ['web', 'has.backend.access'],

    'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'RolesController@getAssets')
        ->name('vh.backend.role.roles.assets');

    /**
     * Get List
     */
    Route::get('/', 'RolesController@getList')
        ->name('vh.backend.role.roles.list');

    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'RolesController@updateList')
        ->name('vh.backend.role.roles.list.update');

    /**
     * Delete List
     */
    Route::delete('/', 'RolesController@deleteList')
        ->name('vh.backend.role.roles.list.delete');

    /**
     * Create Item
     */
    Route::post('/', 'RolesController@createItem')
        ->name('vh.backend.role.roles.create');

    /**
     * Get Item
     */
    Route::get('/{id}', 'RolesController@getItem')
        ->name('vh.backend.role.roles.read');

    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'RolesController@updateItem')
        ->name('vh.backend.role.roles.update');

    /**
     * Delete Item
     */
    Route::delete('/{id}', 'RolesController@deleteItem')
        ->name('vh.backend.role.roles.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'RolesController@listAction')
        ->name('vh.backend.role.roles.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'RolesController@itemAction')
        ->name('vh.backend.role.roles.item.action');

    /**
     * get role permissions
     */
    Route::post('/item/{id}/permissions', 'RolesController@getItemPermission')
        ->name('backend.vaah.roles.item.permissions');

    /**
     * get role users
     */
    Route::get('/item/{id}/users', 'RolesController@getItemUser')
        ->name('backend.vaah.roles.item.users');

    /**
     * toggle actions
     */
    Route::post('/actions/{action_name}', 'RolesController@postActions')
        ->name('backend.vaah.roles.actions');

    /**
     * get module section
     */
    Route::post('/module/{module_name}/sections', 'RolesController@getModuleSections')
        ->name('backend.vaah.roles.module.sections');
    //---------------------------------------------------------

});
