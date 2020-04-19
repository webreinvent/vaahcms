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
        Route::any( '/assets', 'ModulesController@assets' )
            ->name( 'vh.backend.modules.assets' );
        //------------------------------------------------
        Route::any( '/list', 'ModulesController@getList' )
            ->name( 'vh.backend.modules.list' );
        //------------------------------------------------
        Route::any('/item/{id}', 'ModulesController@getItem')
            ->name('backend.vaah.modules.item');
        //---------------------------------------------------------
        Route::any( '/download', 'ModulesController@download' )
            ->name( 'vh.backend.modules.download' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ModulesController@installUpdates' )
            ->name( 'vh.backend.modules.install.updates' );
        //------------------------------------------------
        Route::any( '/actions', 'ModulesController@actions' )
            ->name( 'vh.backend.modules.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ModulesController@getModulesSlugs' )
            ->name( 'vh.backend.modules.get.slugs' );
        //------------------------------------------------
        Route::any( '/store/updates', 'ModulesController@storeUpdates' )
            ->name( 'vh.backend.modules.store.updates' );

        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
