<?php



Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'PublicController@login' )
            ->name( 'vh.backend' );
        //------------------------------------------------
        Route::get( '/login', 'PublicController@redirectToLogin' )
            ->name( 'vh.backend.login' );
        //------------------------------------------------
        Route::any( '/signin/post', 'PublicController@postLogin' )
            ->name( 'vh.backend.signin.post' );
        //------------------------------------------------
        Route::get( '/logout', 'PublicController@logout' )
            ->name( 'vh.backend.logout' );
        //------------------------------------------------
        Route::group(
            [
                'prefix'     => 'json',
                'middleware' => ['web'],
            ],
            function () {
                //------------------------------------------------
                Route::any( '/assets', 'JsonController@getPublicAssets' )
                    ->name( 'vh.backend.json.assets' );
                //------------------------------------------------
                Route::any( '/is-logged-in', 'JsonController@isLoggedIn' )
                    ->name( 'vh.backend.json.is_logged_in' );
                //------------------------------------------------
                Route::any( '/permissions', 'JsonController@getPermissions' )
                    ->name( 'vh.backend.json.permissions' );
                //------------------------------------------------

                //------------------------------------------------
            });
        //------------------------------------------------
    });






Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web', 'has.backend.access'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::post( '/notices/mark-as-read', 'Settings\NotificationsController@markAsRead' )
            ->name( 'vh.backend.notices.mark_as_read' );
        //------------------------------------------------

        Route::group(
            [
                'prefix'     => 'json',
                'middleware' => ['web', 'has.backend.access'],
            ],
            function () {
                //------------------------------------------------
                Route::any( '/users/{name?}', 'JsonController@getUsers' )
                    ->name( 'vh.backend.json.users' );
                //------------------------------------------------

                //------------------------------------------------
            });

        //------------------------------------------------
    });


Route::group(
    [
        'prefix'     => 'backend',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::any( '/signin/post', 'PublicController@postLogin' )
            ->name( 'vh.backend.signin.post' );
        //------------------------------------------------

        //------------------------------------------------
        //------------------------------------------------
    });
