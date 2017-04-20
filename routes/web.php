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
    Route::get('/', 'Admin\ProductController@index');

    // Logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    // User
    Route::get('user/search', 'Admin\UserController@search');
    Route::post('user/action', 'Admin\UserController@action');
    Route::resource('user', 'Admin\UserController');

    // Product
    Route::get('product/search', 'Admin\ProductController@search');
    Route::post('product/action', 'Admin\ProductController@action');
    Route::resource('product', 'Admin\ProductController');

    // Category
    Route::get('category/search', 'Admin\CategoryController@search');
    Route::post('category/action', 'Admin\CategoryController@action');
    Route::resource('category', 'Admin\CategoryController');
});

Route::group(['prefix' => 'admin', 'as' => 'login'], function() {
    Route::get('/login', 'Admin\LoginController@index');
});

Route::post('/authenticate', 'Auth\LoginController@authenticate');