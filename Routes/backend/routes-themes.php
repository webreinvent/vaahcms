<?php

Route::group(
    [
        'prefix' => 'backend/vaah/themes',
        
        'middleware' => ['web', 'has.backend.access'],
        
        'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'ThemesController@getAssets')
        ->name('vh.backend.vaah.themes.assets');
    /**
     * Get List
     */
    Route::get('/', 'ThemesController@getList')
        ->name('vh.backend.vaah.themes.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ThemesController@updateList')
        ->name('vh.backend.vaah.themes.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ThemesController@deleteList')
        ->name('vh.backend.vaah.themes.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'ThemesController@createItem')
        ->name('vh.backend.vaah.themes.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ThemesController@getItem')
        ->name('vh.backend.vaah.themes.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ThemesController@updateItem')
        ->name('vh.backend.vaah.themes.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ThemesController@deleteItem')
        ->name('vh.backend.vaah.themes.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ThemesController@listAction')
        ->name('vh.backend.vaah.themes.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ThemesController@itemAction')
        ->name('vh.backend.vaah.themes.item.action');

    //---------------------------------------------------------

});
