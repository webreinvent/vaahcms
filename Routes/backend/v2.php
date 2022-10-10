<?php


Route::group(
    [
        'prefix'     => 'backend/v2/ui',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'UiController@v2ui' )
            ->name( 'vh.backend.ui' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => 'backend/v2',
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
