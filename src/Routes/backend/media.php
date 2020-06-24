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
        Route::get('/assets', 'MediaController@getAssets')
            ->name('backend.vaah.media.assets');
        //---------------------------------------------------------
        Route::post('/downloadable/slug/available', 'MediaController@isDownloadableSlugAvailable')
            ->name('backend.vaah.media.downloadable.slug.available');
        //---------------------------------------------------------
        Route::post('/create', 'MediaController@postCreate')
            ->name('backend.vaah.media.create');
        //---------------------------------------------------------
        Route::get('/list', 'MediaController@getList')
            ->name('backend.vaah.media.list');
        //---------------------------------------------------------
        Route::get('/item/{id}', 'MediaController@getItem')
            ->name('backend.vaah.media.item');
        //---------------------------------------------------------
        Route::post('/item/{id}/createUser', 'MediaController@createUser')
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



