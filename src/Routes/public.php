<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix'     => '/',
        'middleware' => 'set.theme.details',
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'WelcomeController@index' )
            ->name( 'vh.public.index' );
        //------------------------------------------------
        //------------------------------------------------
        Route::group(
            [
                'prefix'     => '/page/{slug?}',
                'middleware' => 'set.template.details',
            ],
            function () {
                //------------------------------------------------
                //------------------------------------------------
                Route::get( '/', 'WelcomeController@getPage' )
                    ->name( 'vh.public.page' );
                //------------------------------------------------
                //------------------------------------------------
                //------------------------------------------------
                //------------------------------------------------
            });
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });

