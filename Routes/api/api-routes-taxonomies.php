<?php

/*
 * API url will be: <base-url>/public/api/vaah/manage/taxonomies
 */
Route::group(
    [
        'prefix' => 'vaah/manage/taxonomies',
        'namespace' => 'Backend',
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

    });
