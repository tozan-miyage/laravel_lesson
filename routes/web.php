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
Route::get('/', 'WebController@index')->name('web.index');
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('users/carts', 'CartController@index')->name('carts.index');
Route::post('users/carts', 'CartController@store')->name('carts.store');
Route::delete('users/carts', 'CartController@destroy')->name('carts.destroy');
Route::get('products/index', 'ProductController@index')->name('index');

//users/mypageがリクエストされたら、UserController@mypageを実行せよ。名前は{{ mypage }}とする。
Route::get('users/mypage', 'UserController@mypage')->name('mypage');
//users/mypage/editがリクエストされたら、UserController@editを実行せよ。名前は{{ mypage.edit }}とする。
Route::get('users/mypage/edit', 'UserController@edit')->name('mypage.edit');
Route::get('users/mypage/address/edit', 'UserController@edit_address')->name('mypage.edit_address');
Route::put('users/mypage', 'UserController@update')->name('mypage.update');
Route::get('users/mypage/favorite', 'UserController@favorite')->name('mypage.favorite');
Route::post('products/{product}/reviews', 'ReviewController@store');

// データ更新ページを表示
Route::get('users/mypage/password/edit', 'UserController@edit_password')->name('mypage.edit_password');

// データを更新します
Route::put('users/mypage/password', 'UserController@update_password')->name('mypage.update_password');

//POSTで使用するルーティング第1引数商品データ取得URL　第２引数使用するコントローラーと、アクション指定
Route::get('products/{product}/favorite', 'ProductController@favorite')->name('products.favorite');

Route::resource('products', 'ProductController');
//CRUD用URLを一度に定義する
//第1引数＝URL文字列
//第2引数＝使用するコントローラー


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
