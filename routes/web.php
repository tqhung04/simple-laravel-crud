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

// Auth route
Auth::routes();
Route::get('/', 'UserController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    // Default router
    Route::get('/', 'UserController@index');

    // Logout
    Route::get('/logout', 'LoginController@logout')->name('logout');

    // User
    // Route::group(['prefix' => 'user'], function() {
    //     // Route::get('/', 'UserController@index');
    //     // Route::get('/create', 'UserController@store');
    // });
    Route::resource('user', 'UserController');
});

Route::group(['prefix' => 'admin', 'as' => 'login'], function() {
    Route::get('/login', 'LoginController@index');
});
Route::post('/authenticate', 'LoginController@authenticate');