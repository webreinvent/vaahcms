<?php

Route::group(
    [
        'prefix' => 'backend/vaah/registrations',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'RegistrationsController@getAssets')
            ->name('backend.vaah.registrations.assets');
        //---------------------------------------------------------
        Route::post('/create', 'RegistrationsController@postCreate')
            ->name('backend.vaah.registrations.create');
        //---------------------------------------------------------
        Route::get('/list', 'RegistrationsController@getList')
            ->name('backend.vaah.registrations.list');
        //---------------------------------------------------------
        Route::get('/item/{id}', 'RegistrationsController@getItem')
            ->name('backend.vaah.registrations.item');
        //---------------------------------------------------------
        Route::post('/item/{id}/createUser', 'RegistrationsController@createUser')
            ->name('backend.vaah.registrations.item.createUser');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'RegistrationsController@postStore')
            ->name('backend.vaah.registrations.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'RegistrationsController@postActions')
            ->name('backend.vaah.registrations.actions');
        //---------------------------------------------------------
    });
