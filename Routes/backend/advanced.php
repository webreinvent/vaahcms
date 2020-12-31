<?php



Route::group(
    [
        'prefix'     => 'backend/vaah/advanced/logs',
        'middleware' => ['web','has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Advanced'
    ],
    function () {
        Route::post( '/list', 'LogsController@getList');
    });

