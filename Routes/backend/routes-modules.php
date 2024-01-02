<?php

Route::group(
    [
        'prefix' => 'backend/vaah/modules',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'ModulesController@getAssets')
        ->name('vh.backend.vaah.modules.assets');
    /**
     * Get List
     */
    Route::get('/', 'ModulesController@getList')
        ->name('vh.backend.vaah.modules.list');

    /**
     * Get Item
     */
    Route::get('/{id}', 'ModulesController@getItem')
        ->name('vh.backend.vaah.modules.read');


    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ModulesController@actions')
        ->name('vh.backend.vaah.modules.item.action');

    //---------------------------------------------------------

    //------------------------------------------------
    Route::get( '/get/slugs', 'ModulesController@getModulesSlugs' )
        ->name( 'vh.backend.modules.get.slugs' );
    //------------------------------------------------
    Route::post( '/store/updates', 'ModulesController@storeUpdates' )
        ->name( 'vh.backend.modules.store.updates' );
    //---------------------------------------------------------
    Route::post( '/download', 'ModulesController@download' )
        ->name( 'vh.backend.modules.download');
    //------------------------------------------------
    Route::post( '/install/updates', 'ModulesController@installUpdates' )
        ->name( 'vh.backend.modules.install.updates');
    //------------------------------------------------
    Route::any( '/publish/assets', 'ModulesController@publishAssets' )
        ->name( 'vh.setup.publish.assets' );
    //------------------------------------------------

});
