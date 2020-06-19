<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('master.app');
});

Route::resource('product', 'ProductController');
Route::resource('category', 'CategoryController');
Route::get('category/{category}', 'CategoryController@destroy')->name('category.del');
Route::get('product/{product}', 'ProductController@destroy')->name('product.del');
Route::get('order', 'OrderController@index')->name('order.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');