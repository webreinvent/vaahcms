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
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Frontend'
    ],
    function () {
        //------------------------------------------------
        Route::any( '/clear/cache', 'WelcomeController@clearCache' )
            ->name( 'vh.frontend.clear.cache' );
        //------------------------------------------------
        Route::any( '/faker', 'WelcomeController@getFaker' )
            ->name( 'vh.faker' );
        //------------------------------------------------
    });

Route::group(
    [
        'prefix'     => '/',
        'middleware' => ['web', 'set.theme.details'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\Frontend'
    ],
    function () {
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/', 'WelcomeController@index' )
            ->name( 'vh.home' );
        //------------------------------------------------
        Route::get( '/login', 'WelcomeController@index' )
            ->name( 'vh.login' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });




Route::group(
    [
        'prefix'     => 'media',
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers\backend'
    ],
    function () {
        //------------------------------------------------
        Route::get( '/download/{slug?}', 'MediaController@itemDownload' )
            ->name( 'vh.frontend.media.download' );
        //------------------------------------------------
    });


Route::group(
    [
        'middleware' => ['web'],
        'namespace'  => 'WebReinvent\VaahCms\Http\Controllers'
    ],
    function () {
        //------------------------------------------------
        Route::get('/verify-email/{activation_code}', 'PublicController@verifyEmail')
            ->name('vh.verification');
        //------------------------------------------------
    });



