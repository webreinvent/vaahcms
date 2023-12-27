<?php

/*
 * API url will be: <base-url>/public/api/vaah/logs
 */


Route::group(
    [
        'prefix'     => 'api/vaah/logs',
        'middleware' => ['api','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced'
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'LogsController@getAssets')
            ->name('vh.backend.vaah.api.jobs.assets');
        /**
         * Get List
         */
        Route::get('/', 'LogsController@getList')
            ->name('vh.backend.vaah.api.jobs.list');
        /**
         * Get Item
         */
        Route::get('/{name}', 'LogsController@getItem')
            ->name('vh.backend.vaah.api.jobs.read');
        /**
         * Download File
         */
        Route::get( '/download-file/{file_name}', 'LogsController@downloadFile');
        /**
         * Actions
         */
        Route::post( '/actions/{action_name}', 'LogsController@postActions');
    });
