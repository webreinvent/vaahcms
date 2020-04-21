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

        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
