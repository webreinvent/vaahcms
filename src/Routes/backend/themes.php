<?php

Route::group(
    [
        'prefix'     => 'backend/vaah/themes',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'ThemesController@index' )
            ->name( 'vh.backend.themes' );
        //------------------------------------------------
        Route::get( '/assets', 'ThemesController@assets' )
            ->name( 'vh.backend.themes.assets' );
        //------------------------------------------------
        Route::get( '/list', 'ThemesController@getList' )
            ->name( 'vh.backend.themes.list' );
        //------------------------------------------------
        Route::get('/item/{id}', 'ThemesController@getItem')
            ->name('backend.vaah.themes.item');
        //---------------------------------------------------------
        Route::post( '/download', 'ThemesController@download' )
            ->name( 'vh.backend.themes.download' );
        //------------------------------------------------
        Route::post( '/install/updates', 'ThemesController@installUpdates' )
            ->name( 'vh.backend.themes.install.updates' );
        //------------------------------------------------
        Route::post( '/actions', 'ThemesController@actions' )
            ->name( 'vh.backend.themes.actions' );
        //------------------------------------------------
        Route::post( '/get/slugs', 'ThemesController@ThemesSlugs' )
            ->name( 'vh.backend.themes.get.slugs' );
        //------------------------------------------------
        Route::post( '/store/updates', 'ThemesController@storeUpdates' )
            ->name( 'vh.backend.themes.store.updates' );

        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
