<?php

Route::group(
    [
        'prefix' => 'backend/users',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend',
    ],
    function () {
        /**
         * Get Assets
         */
        Route::get('/assets', 'UsersController@getAssets')
            ->name('vh.backend.users.users.assets');
        /**
         * Get List
         */
        Route::get('/', 'UsersController@getList')
            ->name('vh.backend.users.users.list');
        /**
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'UsersController@updateList')
            ->name('vh.backend.users.users.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'UsersController@deleteList')
            ->name('vh.backend.users.users.list.delete');


        /**
         * Create Item
         */
        Route::post('/', 'UsersController@createItem')
            ->name('vh.backend.users.users.create');
        /**
         * Get Item
         */
        Route::get('/{id}', 'UsersController@getItem')
            ->name('vh.backend.users.users.read');
        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'UsersController@updateItem')
            ->name('vh.backend.users.users.update');
        /**
         * Delete Item
         */
        Route::delete('/{id}', 'UsersController@deleteItem')
            ->name('vh.backend.users.users.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'UsersController@listAction')
            ->name('vh.backend.users.users.list.actions');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'UsersController@itemAction')
            ->name('vh.backend.users.users.item.action');

        //---------------------------------------------------------

        //---------------------------------------------------------
        Route::get('/item/{id}/roles', 'UsersController@getItemRoles')
            ->name('backend.vaah.users.role');

        Route::post('/actions/{action_name}', 'UsersController@postActions')
            ->name('backend.vaah.users.actions');
        //---------------------------------------------------------
        Route::post('/avatar/store', 'UsersController@storeAvatar')
            ->name('backend.vaah.users.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'UsersController@removeAvatar')
            ->name('backend.vaah.users.avatar.remove');
        //---------------------------------------------------------
        Route::post('/impersonate/logout', 'UsersController@impersonateLogout')
            ->name('backend.vaah.users.impersonate.logout');
        //---------------------------------------------------------
        Route::post('/impersonate/{uuid}', 'UsersController@impersonate')
            ->name('backend.vaah.users.impersonate');
        //---------------------------------------------------------

    });
