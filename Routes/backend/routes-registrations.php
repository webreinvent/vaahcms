<?php

Route::group(
    [
    'prefix' => 'backend/vaah/registrations',

    'middleware' => ['web', 'has.backend.access'],

    'namespace' => 'WebReinvent\\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'RegistrationsController@getAssets')
        ->name('vh.backend.vaah.registrations.assets');
    /**
     * Get List
     */
    Route::get('/', 'RegistrationsController@getList')
        ->name('vh.backend.vaah.registrations.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'RegistrationsController@updateList')
        ->name('vh.backend.vaah.registrations.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'RegistrationsController@deleteList')
        ->name('vh.backend.vaah.registrations.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'RegistrationsController@createItem')
        ->name('vh.backend.vaah.registrations.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'RegistrationsController@getItem')
        ->name('vh.backend.vaah.registrations.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'RegistrationsController@updateItem')
        ->name('vh.backend.vaah.registrations.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'RegistrationsController@deleteItem')
        ->name('vh.backend.vaah.registrations.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'RegistrationsController@listAction')
        ->name('vh.backend.vaah.registrations.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'RegistrationsController@itemAction')
        ->name('vh.backend.vaah.registrations.item.action');

    //---------------------------------------------------------
    Route::any('/{id}/send-verification-mail', 'RegistrationsController@sendVerificationEmail')
        ->name('vh.backend.vaah.registrations.send_verification_mail');

    Route::post('/{id}/createUser', 'RegistrationsController@createUser')
        ->name('vh.backend.vaah.registrations.item.createUser');
});
