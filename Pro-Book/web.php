<?php
require_once('./libs/route.php');
require_once('./libs/session.php');

/** Auth */
Route::get('login', 'Auth@login');
Route::post('login', 'Auth@handleLogin');
Route::post('loginbygoogle', 'Auth@handleLoginByGoogle');
Route::post('logout', 'Auth@logout');
Route::get('register', 'Auth@register');
Route::post('register', 'Auth@handleRegister');

/** HomeController */
Route::get('home', 'HomeController@index');
Route::get('search', 'HomeController@search');

/** OrderController */
Route::get('book', 'SoapServiceController@getBookDetails');
Route::get('history', 'OrderController@index');

/** ReviewController */
Route::get('review', 'ReviewController@create');
Route::post('review', 'ReviewController@store');

/** UserController */
Route::get('profile', 'UserController@profile');
Session::start();
if (!Session::exist('isloginbygoogle')){
  Route::get('profile/edit', 'UserController@edit');
}
Route::put('profile/edit', 'UserController@update');

/** API */
Route::post('apis/create-order', 'CreateOrder');
Route::get('apis/validate-email', 'ValidateEmail');
Route::get('apis/validate-username', 'ValidateUsername');

//Experimental
Route::post('books', 'SoapServiceController@searchBooks');
