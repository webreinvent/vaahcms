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
        'prefix'     => '/backend/',
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


include('backend/general.php');
include('backend/ui.php');
include('backend/setup.php');
include('backend/settings.php');
include('backend/routes-media.php');
include('backend/routes-taxonomies.php');
include('backend/profile.php');
include('backend/advanced.php');
include('backend/routes-roles.php');
include('backend/routes-permissions.php');
include('backend/routes-registrations.php');
include('backend/routes-users.php');
include('backend/routes-modules.php');
include('backend/routes-themes.php');



