<?php



Route::group(
    [
        'prefix'     => 'backend/vaah/logs',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced'
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'LogsController@getAssets')
            ->name('vh.backend.vaah.jobs.assets');
        /**
         * Get List
         */
        Route::get('/', 'LogsController@getList')
            ->name('vh.backend.vaah.jobs.list');
        /**
         * Get Item
         */
        Route::get('/{name}', 'LogsController@getItem')
            ->name('vh.backend.vaah.jobs.read');
        /**
         * Download File
         */
        Route::get( '/download-file/{file_name}', 'LogsController@downloadFile');
        /**
         * Actions
         */
        Route::post( '/actions/{action_name}', 'LogsController@postActions');
    });



Route::group(
    [
        'prefix' => 'backend/vaah/batches',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced',
    ],
    function () {
        //---------------------------------------------------------
        /**
         * Get Assets
         */
        Route::get('/assets', 'BatchesController@getAssets')
            ->name('vh.backend.vaah.batches.assets');
        /**
         * Get List
         */
        Route::get('/', 'BatchesController@getList')
            ->name('vh.backend.vaah.batches.list');

        /**
         * Delete List
         */
        Route::delete('/', 'BatchesController@deleteList')
            ->name('vh.backend.vaah.batches.list.delete');

        /**
         * Delete Item
         */
        Route::delete('/{id}', 'BatchesController@deleteItem')
            ->name('vh.backend.vaah.batches.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'BatchesController@listAction')
            ->name('vh.backend.vaah.batches.list.actions');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'BatchesController@itemAction')
            ->name('vh.backend.vaah.batches.item.action');

        //---------------------------------------------------------
        //---------------------------------------------------------
    });





Route::group(
    [
        'prefix' => 'backend/vaah/jobs',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced',
    ],
    function () {
        /**
         * Get Assets
         */
        Route::get('/assets', 'JobsController@getAssets')
            ->name('vh.backend.vaah.jobs.assets');
        /**
         * Get List
         */
        Route::get('/', 'JobsController@getList')
            ->name('vh.backend.vaah.jobs.list');

        /**
         * Delete List
         */
        Route::delete('/', 'JobsController@deleteList')
            ->name('vh.backend.vaah.jobs.list.delete');

        /**
         * Delete Item
         */
        Route::delete('/{id}', 'JobsController@deleteItem')
            ->name('vh.backend.vaah.jobs.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'JobsController@listAction')
            ->name('vh.backend.vaah.jobs.list.actions');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'JobsController@itemAction')
            ->name('vh.backend.vaah.jobs.item.action');

        //---------------------------------------------------------

    });



Route::group(
    [
        'prefix' => 'backend/vaah/failedjobs',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Backend\Advanced',
    ],
    function () {
        /**
         * Get Assets
         */
        Route::get('/assets', 'FailedJobsController@getAssets')
            ->name('vh.backend.vaah.failedjobs.assets');
        /**
         * Get List
         */
        Route::get('/', 'FailedJobsController@getList')
            ->name('vh.backend.vaah.failedjobs.list');
        /**
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'FailedJobsController@updateList')
            ->name('vh.backend.vaah.failedjobs.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'FailedJobsController@deleteList')
            ->name('vh.backend.vaah.failedjobs.list.delete');

        /**
         * Delete Item
         */
        Route::delete('/{id}', 'FailedJobsController@deleteItem')
            ->name('vh.backend.vaah.failedjobs.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'FailedJobsController@listAction')
            ->name('vh.backend.vaah.failedjobs.list.actions');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'FailedJobsController@itemAction')
            ->name('vh.backend.vaah.failedjobs.item.action');

        //---------------------------------------------------------
    });

