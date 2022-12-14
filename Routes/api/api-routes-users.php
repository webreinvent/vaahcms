<?php

/*
 * API url will be: <base-url>/public/api/users/users
 */
Route::group(
    [
        'prefix' => 'users/users',
        'namespace' => 'Backend',
    ],
    function () {

        /**
         * Get Assets
         */
        Route::get('/assets', 'UsersController@getAssets')
            ->name('vh.backend.users.api.users.assets');
        /**
         * Get List
         */
        Route::get('/', 'UsersController@getList')
            ->name('vh.backend.users.api.users.list');
        /**
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'UsersController@updateList')
            ->name('vh.backend.users.api.users.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'UsersController@deleteList')
            ->name('vh.backend.users.api.users.list.delete');


        /**
         * Create Item
         */
        Route::post('/', 'UsersController@createItem')
            ->name('vh.backend.users.api.users.create');
        /**
         * Get Item
         */
        Route::get('/{id}', 'UsersController@getItem')
            ->name('vh.backend.users.api.users.read');
        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'UsersController@updateItem')
            ->name('vh.backend.users.api.users.update');
        /**
         * Delete Item
         */
        Route::delete('/{id}', 'UsersController@deleteItem')
            ->name('vh.backend.users.api.users.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'UsersController@listAction')
            ->name('vh.backend.users.api.users.list.action');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'UsersController@itemAction')
            ->name('vh.backend.users.api.users.item.action');



    });
