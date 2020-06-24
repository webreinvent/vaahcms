<?php


Route::group(
    [
        'prefix'     => 'backend/ui',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'UiController@index' )
            ->name( 'vh.backend.ui' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
