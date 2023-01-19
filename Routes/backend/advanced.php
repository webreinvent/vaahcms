<?php



Route::group(
    [
        'prefix'     => 'backend/vaah/advanced/logs',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Advanced'
    ],
    function () {
        //---------------------------------------------------------
        Route::post( '/list', 'LogsController@getList');
        //---------------------------------------------------------
        Route::post( '/item/{name}', 'LogsController@getItem');
        //---------------------------------------------------------
        Route::get( '/download-file/{file_name}', 'LogsController@downloadFile');
        //---------------------------------------------------------
        Route::post( '/actions/{action_name}', 'LogsController@postActions');

    });



Route::group(
    [
        'prefix' => 'backend/vaah/advanced/batches',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Advanced',
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'BatchesController@getAssets')
            ->name('vh.backend.job_batches.batches.assets');
        //---------------------------------------------------------
        Route::any('/list', 'BatchesController@getList')
            ->name('vh.backend.job_batches.batches.list');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'BatchesController@postActions')
            ->name('vh.backend.job_batches.batches.actions');
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
        'prefix' => 'backend/vaah/advanced/failed-jobs',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Advanced',
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'FailedJobsController@getAssets')
            ->name('vh.backend.jobs.jobs.assets');
        //---------------------------------------------------------
        Route::any('/list', 'FailedJobsController@getList')
            ->name('vh.backend.jobs.jobs.list');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'FailedJobsController@postActions')
            ->name('vh.backend.jobs.jobs.actions');
        //---------------------------------------------------------
    });

