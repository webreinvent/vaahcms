<?php



Route::group(
    [
        'prefix' => 'backend/vaah/permissions',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'PermissionsController@getAssets')
            ->name('backend.vaah.permissions.assets');
        //---------------------------------------------------------
        Route::get('/list', 'PermissionsController@getList')
            ->name('backend.vaah.permissions.list');
        //---------------------------------------------------------
        Route::get('/item/{id}', 'PermissionsController@getItem')
            ->name('backend.vaah.permissions.item');
        //---------------------------------------------------------
        Route::get('/item/{id}/roles', 'PermissionsController@getItemRoles')
            ->name('backend.vaah.permissions.role');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'PermissionsController@postStore')
            ->name('backend.vaah.permissions.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'PermissionsController@postActions')
            ->name('backend.vaah.permissions.actions');
        //---------------------------------------------------------
        Route::get('/getModuleSections', 'PermissionsController@getModuleSections')
            ->name('backend.vaah.permissions.module-section');
        //---------------------------------------------------------
    });
