<?php

Route::group(
    [
        'prefix'     => 'backend/media',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::post( '/upload', 'MediaController@upload' )
            ->name( 'vh.backend.media.upload' );
        //------------------------------------------------
        Route::any('/assets', 'MediaController@getAssets')
            ->name('backend.vaah.media.assets');
        //---------------------------------------------------------
        Route::post('/create', 'MediaController@postCreate')
            ->name('backend.vaah.media.create');
        //---------------------------------------------------------
        Route::post('/list', 'MediaController@getList')
            ->name('backend.vaah.media.list');
        //---------------------------------------------------------
        Route::any('/item/{id}', 'MediaController@getItem')
            ->name('backend.vaah.media.item');
        //---------------------------------------------------------
        Route::any('/item/{id}/createUser', 'MediaController@createUser')
            ->name('backend.vaah.media.item.createUser');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'MediaController@postStore')
            ->name('backend.vaah.media.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'MediaController@postActions')
            ->name('backend.vaah.media.actions');
        //------------------------------------------------

        //------------------------------------------------
    });
