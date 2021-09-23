<?php

Route::group(
[
    'prefix'     => 'backend/taxonomies',
    'middleware' => ['web','has.backend.access'],
    'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
],
function () {
     //---------------------------------------------------------
    Route::get('/', 'TaxonomiesController@getIndex')
    ->name('vh.backend.leads.taxonomies');
     //---------------------------------------------------------
    Route::any('/assets', 'TaxonomiesController@getAssets')
    ->name('vh.backend.leads.taxonomies.assets');
     //---------------------------------------------------------
    Route::post('/create', 'TaxonomiesController@postCreate')
    ->name('vh.backend.leads.taxonomies.create');
     //---------------------------------------------------------
    Route::any('/list', 'TaxonomiesController@getList')
    ->name('vh.backend.leads.taxonomies.list');
     //---------------------------------------------------------
    Route::any('/item/{uuid}', 'TaxonomiesController@getItem')
    ->name('vh.backend.leads.taxonomies.item');
     //---------------------------------------------------------
    Route::post('/store/{uuid}', 'TaxonomiesController@postStore')
    ->name('vh.backend.leads.taxonomies.store');
     //---------------------------------------------------------
    Route::post('/actions/{action_name}', 'TaxonomiesController@postActions')
    ->name('vh.backend.leads.taxonomies.actions');
     //---------------------------------------------------------
    Route::get('/json/parents/{id}/{name?}', 'TaxonomiesController@getParents' )
    ->name( 'vh.backend.leads.taxonomies.countries' );
    //------------------------------------------------
    Route::get( 'json/getCountryById/{id}', 'TaxonomiesController@getCountryById' )
        ->name( 'vh.backend.leads.taxonomies.getCountryById' );
            //------------------------------------------------
    Route::post( 'createTaxonomyType', 'TaxonomiesController@createTaxonomyType' )
        ->name( 'vh.backend.leads.taxonomies.createTaxonomyType' );
            //------------------------------------------------
    Route::post( 'deleteTaxonomyType', 'TaxonomiesController@deleteTaxonomyType' )
        ->name( 'vh.backend.leads.taxonomies.deleteTaxonomyType' );
            //------------------------------------------------
    Route::post( 'updateTaxonomyType', 'TaxonomiesController@updateTaxonomyType' )
        ->name( 'vh.backend.leads.taxonomies.updateTaxonomyType' );
            //------------------------------------------------
    Route::post( 'updateTaxonomyTypePosition', 'TaxonomiesController@updateTaxonomyTypePosition' )
        ->name( 'vh.backend.leads.taxonomies.updateTaxonomyTypePosition' );
            //------------------------------------------------
});
