<?php

/*
 * API url will be: <base-url>/public/api/vaah/registrations
 */
Route::group(
    [
        'prefix' => 'vaah/registrations',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'RegistrationsController@getAssets')
        ->name('vh.backend.vaah.api.registrations.assets');
    /**
     * Get List
     */
    Route::get('/', 'RegistrationsController@getList')
        ->name('vh.backend.vaah.api.registrations.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'RegistrationsController@updateList')
        ->name('vh.backend.vaah.api.registrations.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'RegistrationsController@deleteList')
        ->name('vh.backend.vaah.api.registrations.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'RegistrationsController@createItem')
        ->name('vh.backend.vaah.api.registrations.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'RegistrationsController@getItem')
        ->name('vh.backend.vaah.api.registrations.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'RegistrationsController@updateItem')
        ->name('vh.backend.vaah.api.registrations.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'RegistrationsController@deleteItem')
        ->name('vh.backend.vaah.api.registrations.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'RegistrationsController@listAction')
        ->name('vh.backend.vaah.api.registrations.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'RegistrationsController@itemAction')
        ->name('vh.backend.vaah.api.registrations.item.action');



});
