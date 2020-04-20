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
        Route::any( '/assets', 'ThemesController@assets' )
            ->name( 'vh.backend.themes.assets' );
        //------------------------------------------------
        Route::any( '/list', 'ThemesController@getList' )
            ->name( 'vh.backend.themes.list' );
        //------------------------------------------------
        Route::any('/item/{id}', 'ThemesController@getItem')
            ->name('backend.vaah.themes.item');
        //---------------------------------------------------------
        Route::any( '/download', 'ThemesController@download' )
            ->name( 'vh.backend.themes.download' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ThemesController@installUpdates' )
            ->name( 'vh.backend.themes.install.updates' );
        //------------------------------------------------
        Route::any( '/actions', 'ThemesController@actions' )
            ->name( 'vh.backend.themes.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ThemesController@ThemesSlugs' )
            ->name( 'vh.backend.themes.get.slugs' );
        //------------------------------------------------
        Route::any( '/store/updates', 'ThemesController@storeUpdates' )
            ->name( 'vh.backend.themes.store.updates' );

        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
