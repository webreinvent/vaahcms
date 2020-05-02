<?php



Route::group(
    [
        'prefix' => 'backend/vaah/users',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::post('/assets', 'UsersController@getAssets')
            ->name('backend.vaah.users.assets');
        //---------------------------------------------------------
        Route::post('/create', 'UsersController@postCreate')
            ->name('backend.vaah.users.create');
        //---------------------------------------------------------
        Route::post('/list', 'UsersController@getList')
            ->name('backend.vaah.users.list');
        //---------------------------------------------------------
        Route::post('/item/{id}', 'UsersController@getItem')
            ->name('backend.vaah.users.item');
        //---------------------------------------------------------
        Route::post('/item/{id}/roles', 'UsersController@getItemRoles')
            ->name('backend.vaah.users.role');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'UsersController@postStore')
            ->name('backend.vaah.users.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'UsersController@postActions')
            ->name('backend.vaah.users.actions');
        //---------------------------------------------------------
        Route::post('/avatar/store', 'UsersController@storeAvatar')
            ->name('backend.vaah.users.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'UsersController@removeAvatar')
            ->name('backend.vaah.users.avatar.remove');
        //---------------------------------------------------------
    });
