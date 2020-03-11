<?php


Route::group(
    [
        'prefix'     => 'admin/ui',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Admin'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'UiController@index' )
            ->name( 'vh.admin.ui' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
