<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('master.app');
});

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    // User needs to be authenticated to enter here.
    Route::resource('product', 'ProductController');
    Route::resource('category', 'CategoryController');
    Route::get('category/{category}', 'CategoryController@destroy')->name('category.del');
    Route::get('product/{product}', 'ProductController@destroy')->name('product.del');
    Route::get('order', 'OrderController@index')->name('order.index');
    Route::get('result', 'ResultController@index')->name('result.index');
});
Route::get('logout', 'Auth\LoginController@logout')->name('logout');