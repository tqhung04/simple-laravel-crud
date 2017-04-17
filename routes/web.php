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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    // Default router
    Route::get('/', 'UserController@index');

    // Logout
    Route::get('/logout', 'LoginController@logout')->name('logout');

    // User
    Route::get('user/search', 'UserController@search');
    Route::post('user/action', 'UserController@action');
    Route::resource('user', 'UserController');

    // Product
    Route::get('product/search', 'ProductController@search');
    Route::resource('product', 'ProductController');
    Route::post('product/action', 'ProductController@action');

    // Category
    Route::get('category/search', 'CategoryController@search');
    Route::resource('category', 'CategoryController');
    Route::post('category/action', 'CategoryController@action');
});

Route::group(['prefix' => 'admin', 'as' => 'login'], function() {
    Route::get('/login', 'LoginController@index');
});
Route::post('/authenticate', 'LoginController@authenticate');