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
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'LogsController@updateList')
            ->name('vh.backend.vaah.jobs.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'LogsController@deleteList')
            ->name('vh.backend.vaah.jobs.list.delete');


        /**
         * Create Item
         */
        Route::post('/', 'LogsController@createItem')
            ->name('vh.backend.vaah.jobs.create');
        /**
         * Get Item
         */
        Route::get('/{name}', 'LogsController@getItem')
            ->name('vh.backend.vaah.jobs.read');
        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'LogsController@updateItem')
            ->name('vh.backend.vaah.jobs.update');
        /**
         * Delete Item
         */
        Route::delete('/{id}', 'LogsController@deleteItem')
            ->name('vh.backend.vaah.jobs.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'LogsController@listAction')
            ->name('vh.backend.vaah.jobs.list.actions');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'LogsController@itemAction')
            ->name('vh.backend.vaah.jobs.item.action');

        //---------------------------------------------------------

        Route::get( '/download-file/{file_name}', 'LogsController@downloadFile');
        //---------------------------------------------------------
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
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'BatchesController@updateList')
            ->name('vh.backend.vaah.batches.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'BatchesController@deleteList')
            ->name('vh.backend.vaah.batches.list.delete');


        /**
         * Create Item
         */
        Route::post('/', 'BatchesController@createItem')
            ->name('vh.backend.vaah.batches.create');
        /**
         * Get Item
         */
        Route::get('/{id}', 'BatchesController@getItem')
            ->name('vh.backend.vaah.batches.read');
        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'BatchesController@updateItem')
            ->name('vh.backend.vaah.batches.update');
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
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'JobsController@updateList')
            ->name('vh.backend.vaah.jobs.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'JobsController@deleteList')
            ->name('vh.backend.vaah.jobs.list.delete');


        /**
         * Create Item
         */
        Route::post('/', 'JobsController@createItem')
            ->name('vh.backend.vaah.jobs.create');
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
         * Create Item
         */
        Route::post('/', 'FailedJobsController@createItem')
            ->name('vh.backend.vaah.failedjobs.create');
        /**
         * Get Item
         */
        Route::get('/{id}', 'FailedJobsController@getItem')
            ->name('vh.backend.vaah.failedjobs.read');
        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'FailedJobsController@updateItem')
            ->name('vh.backend.vaah.failedjobs.update');
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

