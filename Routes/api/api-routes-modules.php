<?php

/*
 * API url will be: <base-url>/public/api/vaah/modules
 */
Route::group(
    [
        'prefix' => 'api/vaah/modules',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'ModulesController@getAssets')
        ->name('vh.backend.vaah.api.modules.assets');
    /**
     * Get List
     */
    Route::get('/', 'ModulesController@getList')
        ->name('vh.backend.vaah.api.modules.list');

    /**
     * Get Item
     */
    Route::get('/{id}', 'ModulesController@getItem')
        ->name('vh.backend.vaah.api.modules.read');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'ModulesController@actions')
        ->name('vh.backend.vaah.api.modules.item.action');

    //---------------------------------------------------------

    //------------------------------------------------
    Route::get( '/get/slugs', 'ModulesController@getModulesSlugs' )
        ->name( 'vh.backend.vaah.api.modules.get.slugs' );
    //------------------------------------------------
    Route::post( '/store/updates', 'ModulesController@storeUpdates' )
        ->name( 'vh.backend.vaah.api.modules.store.updates' );
    //---------------------------------------------------------
    Route::post( '/download', 'ModulesController@download' )
        ->name( 'vh.backend.vaah.api.modules.download');
    //------------------------------------------------
    Route::post( '/install/updates', 'ModulesController@installUpdates' )
        ->name( 'vh.backend.vaah.api.modules.install.updates');
    //------------------------------------------------
    Route::any( '/publish/assets', 'ModulesController@publishAssets' )
        ->name( 'vh.setup.publish.assets' );
    //------------------------------------------------

});
