<?php

/*
 * API url will be: <base-url>/public/api/vaah/themes
 */
Route::group(
    [
        'prefix' => 'vaah/themes',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'ThemesController@getAssets')
        ->name('vh.backend.vaah.api.themes.assets');
    /**
     * Get List
     */
    Route::get('/', 'ThemesController@getList')
        ->name('vh.backend.vaah.api.themes.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'ThemesController@updateList')
        ->name('vh.backend.vaah.api.themes.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'ThemesController@deleteList')
        ->name('vh.backend.vaah.api.themes.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'ThemesController@createItem')
        ->name('vh.backend.vaah.api.themes.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'ThemesController@getItem')
        ->name('vh.backend.vaah.api.themes.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'ThemesController@updateItem')
        ->name('vh.backend.vaah.api.themes.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'ThemesController@deleteItem')
        ->name('vh.backend.vaah.api.themes.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'ThemesController@listAction')
        ->name('vh.backend.vaah.api.themes.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ThemesController@itemAction')
        ->name('vh.backend.vaah.api.themes.item.action');



});
