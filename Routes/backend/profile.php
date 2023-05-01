<?php
Route::group(
    [
        'prefix' => 'backend/vaah/profile',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::post('/', 'UsersController@getProfile')
            ->name('backend.vaah.profile');
        //---------------------------------------------------------
        Route::post('/assets', 'UsersController@getAssets')
            ->name('backend.vaah.profile.assets');
        //---------------------------------------------------------
        Route::post('/store', 'UsersController@storeProfile')
            ->name('backend.vaah.profile.store');
        //---------------------------------------------------------
        Route::post('/store/password', 'UsersController@storeProfilePassword')
            ->name('backend.vaah.profile.store.password');
        //---------------------------------------------------------
        Route::post('/avatar/store', 'UsersController@storeProfileAvatar')
            ->name('backend.vaah.profile.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'UsersController@removeProfileAvatar')
            ->name('backend.vaah.profile.avatar.remove');
        //---------------------------------------------------------
    });
