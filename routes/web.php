<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('master.app');
});

Route::resource('product', 'ProductController');
Route::resource('category', 'CategoryController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');