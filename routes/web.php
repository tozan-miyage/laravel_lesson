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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', 'ProductController');
//CRUD用URLを一度に定義する
//第1引数＝URL文字列
//第2引数＝使用するコントローラー


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
