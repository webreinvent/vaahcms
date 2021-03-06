<?php

Route::group(
    [
        'prefix'     => 'backend/vaah/modules',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'ModulesController@index' )
            ->name( 'vh.backend.modules' );
        //------------------------------------------------
        Route::get( '/assets', 'ModulesController@assets' )
            ->name( 'vh.backend.modules.assets' );
        //------------------------------------------------
        Route::get( '/list', 'ModulesController@getList' )
            ->name( 'vh.backend.modules.list' );
        //------------------------------------------------
        Route::get('/item/{id}', 'ModulesController@getItem')
            ->name('backend.vaah.modules.item');
        //---------------------------------------------------------
        Route::post( '/download', 'ModulesController@download' )
            ->name( 'vh.backend.modules.download' );
        //------------------------------------------------
        Route::post( '/install/updates', 'ModulesController@installUpdates' )
            ->name( 'vh.backend.modules.install.updates' );
        //------------------------------------------------
        Route::post( '/actions', 'ModulesController@actions' )
            ->name( 'vh.backend.modules.actions' );
        //------------------------------------------------
        Route::get( '/get/slugs', 'ModulesController@getModulesSlugs' )
            ->name( 'vh.backend.modules.get.slugs' );
        //------------------------------------------------
        Route::post( '/store/updates', 'ModulesController@storeUpdates' )
            ->name( 'vh.backend.modules.store.updates' );

        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
