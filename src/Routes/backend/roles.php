<?php


Route::group(
    [
        'prefix'     => 'backend/vaah/roles',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/assets', 'RolesController@getAssets' )
            ->name( 'vh.backend.roles.assets' );
        //---------------------------------------------------------
        Route::post('/create', 'RolesController@postCreate')
            ->name('backend.vaah.registrations.create');
        //------------------------------------------------
        Route::get( '/list', 'RolesController@getList' )
            ->name( 'vh.backend.roles.list' );
        //------------------------------------------------
        Route::get('/item/{id}', 'RolesController@getItem')
            ->name('backend.vaah.roles.item');
        //---------------------------------------------------------
        Route::post('/item/{id}/permissions', 'RolesController@getItemPermission')
            ->name('backend.vaah.roles.item.permissions');
        //---------------------------------------------------------
        Route::get('/item/{id}/users', 'RolesController@getItemUser')
            ->name('backend.vaah.roles.item.users');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'RolesController@postStore')
            ->name('backend.vaah.roles.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'RolesController@postActions')
            ->name('backend.vaah.roles.actions');
        //---------------------------------------------------------
        //------------------------------------------------
    });
