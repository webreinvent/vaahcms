<?php


Route::group(
    [
        'prefix' => 'backend/vaah/settings/localization',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Settings',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::any('/assets', 'LocalizationController@getAssets')
            ->name('backend.vaah.localization.assets');
        //---------------------------------------------------------
        Route::post('/list', 'LocalizationController@getList')
            ->name('backend.vaah.localization.list');
        //---------------------------------------------------------
        Route::post('/store/{id}', 'LocalizationController@postStore')
            ->name('backend.vaah.localization.store');
        //---------------------------------------------------------
        Route::post('/store/language', 'LocalizationController@storeLanguage')
            ->name('backend.vaah.localization.store');
        //---------------------------------------------------------
        Route::post('/store/category', 'LocalizationController@storeCategory')
            ->name('backend.vaah.localization.store');
        //---------------------------------------------------------
        Route::post('/actions/{action_name}', 'LocalizationController@postActions')
            ->name('backend.vaah.localization.actions');
        //---------------------------------------------------------
    });

