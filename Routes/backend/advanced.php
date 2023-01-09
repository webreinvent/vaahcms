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

