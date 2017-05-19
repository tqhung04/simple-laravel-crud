<?php
use App\Http\Middleware\CheckStatus;

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

    // Logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => 'status'], function() {
        // Default router
        Route::get('/', 'Admin\ProductController@index');

        // User
        Route::get('user/search', 'Admin\UserController@search')->name('user.search');
        Route::post('user/bulkAction', 'Admin\UserController@bulkAction');
        Route::resource('user', 'Admin\UserController');

        // Product
        Route::get('product/search', 'Admin\ProductController@search')->name('product.search');;
        Route::post('product/bulkAction', 'Admin\ProductController@bulkAction');
        Route::resource('product', 'Admin\ProductController');

        // Category
        Route::get('category/search', 'Admin\CategoryController@search')->name('category.search');;
        Route::post('category/bulkAction', 'Admin\CategoryController@bulkAction');
        Route::resource('category', 'Admin\CategoryController');
    });
});

Route::group(['prefix' => 'admin', 'as' => 'login'], function() {
    Route::get('/login', 'Auth\LoginController@login');
});

Route::post('/authenticate', 'Auth\LoginController@authenticate');