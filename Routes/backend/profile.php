<?php
Route::group(
    [
        'prefix' => 'backend/vaah/profile',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Backend',
        'middleware' => ['web', 'has.backend.access'],
    ],
    function () {
        //---------------------------------------------------------
        Route::post('/', 'ProfileController@getItem')
            ->name('backend.vaah.profile');
        //---------------------------------------------------------
        Route::post('/assets', 'ProfileController@getAssets')
            ->name('backend.vaah.profile.assets');
        //---------------------------------------------------------
        Route::post('/store', 'ProfileController@storeItem')
            ->name('backend.vaah.profile.store');
        //---------------------------------------------------------
        Route::post('/store/password', 'ProfileController@storePassword')
            ->name('backend.vaah.profile.store.password');
        //---------------------------------------------------------
        Route::post('/avatar/store', 'ProfileController@storeAvatar')
            ->name('backend.vaah.profile.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'ProfileController@removeAvatar')
            ->name('backend.vaah.profile.avatar.remove');
        //---------------------------------------------------------
    });
