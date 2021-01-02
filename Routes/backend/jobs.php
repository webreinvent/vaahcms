<?php

Route::group(
[
 'prefix' => 'backend/jobs',
 'middleware' => ['web', 'has.backend.access'],
 'namespace' => 'WebReinvent\VaahCms\Http\Controllers',
],
function () {
     //---------------------------------------------------------
     Route::get('/', 'JobsController@getIndex')
    ->name('vh.backend.jobs.jobs');
     //---------------------------------------------------------
     Route::any('/assets', 'JobsController@getAssets')
    ->name('vh.backend.jobs.jobs.assets');
     //---------------------------------------------------------
     Route::post('/create', 'JobsController@postCreate')
    ->name('vh.backend.jobs.jobs.create');
     //---------------------------------------------------------
     Route::any('/list', 'JobsController@getList')
    ->name('vh.backend.jobs.jobs.list');
     //---------------------------------------------------------
     Route::any('/item/{uuid}', 'JobsController@getItem')
    ->name('vh.backend.jobs.jobs.item');
     //---------------------------------------------------------
     Route::post('/store/{uuid}', 'JobsController@postStore')
    ->name('vh.backend.jobs.jobs.store');
     //---------------------------------------------------------
     Route::post('/actions/{action_name}', 'JobsController@postActions')
    ->name('vh.backend.jobs.jobs.actions');
     //---------------------------------------------------------
});
