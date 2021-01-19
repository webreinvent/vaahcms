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
        Route::post( '/actions/{action_name}', 'LogsController@postActions');

    });



Route::group(
    [
        'prefix' => 'backend/batches',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'WebReinvent\VaahCms\Http\Controllers\Advanced',
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/', 'BatchesController@getIndex')
            ->name('vh.backend.job_batches.batches');
        //---------------------------------------------------------
        Route::any('/assets', 'BatchesController@getAssets')
            ->name('vh.backend.job_batches.batches.assets');
        //---------------------------------------------------------
        Route::post('/create', 'BatchesController@postCreate')
            ->name('vh.backend.job_batches.batches.create');
        //---------------------------------------------------------
        Route::any('/list', 'BatchesController@getList')
            ->name('vh.backend.job_batches.batches.list');
        //---------------------------------------------------------
        Route::any('/item/{uuid}', 'BatchesController@getItem')
            ->name('vh.backend.job_batches.batches.item');
        //---------------------------------------------------------
        Route::post('/store/{uuid}', 'BatchesController@postStore')
            ->name('vh.backend.job_batches.batches.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'BatchesController@postActions')
            ->name('vh.backend.job_batches.batches.actions');
        //---------------------------------------------------------
    });

