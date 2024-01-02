<?php

/*
 * API url will be: <base-url>/public/api/vaah/manage/taxonomies
 */
Route::group(
    [
        'prefix' => 'api/vaah/manage/taxonomies',
        'middleware' => ['auth:api'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend',
    ],
    function () {

        /**
         * Get Assets
         */
        Route::get('/assets', 'TaxonomiesController@getAssets')
            ->name('vh.backend.vaah.api.taxonomies.assets');

        /**
         * Get List
         */
        Route::get('/', 'TaxonomiesController@getList')
            ->name('vh.backend.vaah.api.taxonomies.list');

        /**
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'TaxonomiesController@updateList')
            ->name('vh.backend.vaah.api.taxonomies.list.update');

        /**
         * Delete List
         */
        Route::delete('/', 'TaxonomiesController@deleteList')
            ->name('vh.backend.vaah.api.taxonomies.list.delete');

        /**
         * Create Item
         */
        Route::post('/', 'TaxonomiesController@createItem')
            ->name('vh.backend.vaah.api.taxonomies.create');

        /**
         * Get Item
         */
        Route::get('/{id}', 'TaxonomiesController@getItem')
            ->name('vh.backend.vaah.api.taxonomies.read');

        /**
         * Get List by type id
         */
        Route::get('/type/{id}', 'TaxonomiesController@getListByTypeId')
            ->name('vh.backend.vaah.taxonomies.type.id');

        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'TaxonomiesController@updateItem')
            ->name('vh.backend.vaah.api.taxonomies.update');

        /**
         * Delete Item
         */
        Route::delete('/{id}', 'TaxonomiesController@deleteItem')
            ->name('vh.backend.vaah.api.taxonomies.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'TaxonomiesController@listAction')
            ->name('vh.backend.vaah.api.taxonomies.list.action');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'TaxonomiesController@itemAction')
            ->name('vh.backend.vaah.api.taxonomies.item.action');


        /**
         * Create taxonomy type
         */
        Route::post( '/create-taxonomy-type', 'TaxonomiesController@createTaxonomyType' )
            ->name( 'vh.backend.leads.taxonomies.createTaxonomyType' );

        /**
         * Delete taxonomy type
         */
        Route::post( '/delete-taxonomy-type', 'TaxonomiesController@deleteTaxonomyType' )
            ->name( 'vh.backend.leads.taxonomies.deleteTaxonomyType' );

        /**
         * Update taxonomy type
         */
        Route::post( '/update-taxonomy-type', 'TaxonomiesController@updateTaxonomyType' )
            ->name( 'vh.backend.leads.taxonomies.updateTaxonomyType' );

        /**
         * Update taxonomy type positions
         */
        Route::post( 'update-taxonomy-type-position', 'TaxonomiesController@updateTaxonomyTypePosition' )
            ->name( 'vh.backend.leads.taxonomies.updateTaxonomyTypePosition' );

        /**
         * Get parent
         */
        Route::get('/json/parents/{id}/{name?}', 'TaxonomiesController@getParents' )
            ->name( 'vh.backend.leads.taxonomies.countries' );

        /**
         * Get country by ID
         */
        Route::get( 'json/getCountryById/{id}', 'TaxonomiesController@getCountryById' )
            ->name( 'vh.backend.leads.taxonomies.getCountryById' );
        //---------------------------------------------------------

    });
