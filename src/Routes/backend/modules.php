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
        Route::get( '/', 'ModuleController@index' )
            ->name( 'vh.backend.modules' );
        //------------------------------------------------
        Route::any( '/assets', 'ModuleController@assets' )
            ->name( 'vh.backend.modules.assets' );
        //------------------------------------------------
        Route::any( '/list', 'ModuleController@getList' )
            ->name( 'vh.backend.modules.list' );
        //------------------------------------------------
        Route::any('/item/{id}', 'ModuleController@getItem')
            ->name('backend.vaah.modules.item');
        //---------------------------------------------------------
        Route::any( '/download', 'ModuleController@download' )
            ->name( 'vh.backend.modules.download' );
        //------------------------------------------------
        Route::any( '/install/updates', 'ModuleController@installUpdates' )
            ->name( 'vh.backend.modules.install.updates' );
        //------------------------------------------------
        Route::any( '/actions', 'ModuleController@actions' )
            ->name( 'vh.backend.modules.actions' );
        //------------------------------------------------
        Route::any( '/get/slugs', 'ModuleController@getModulesSlugs' )
            ->name( 'vh.backend.modules.get.slugs' );
        //------------------------------------------------
        Route::any( '/store/updates', 'ModuleController@storeUpdates' )
            ->name( 'vh.backend.modules.store.updates' );

        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
