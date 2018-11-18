<?php
require_once('./libs/route.php');

/** Auth */
Route::get('login', 'Auth@login');
Route::post('login', 'Auth@handleLogin');
Route::post('logout', 'Auth@logout');
Route::get('register', 'Auth@register');
Route::post('register', 'Auth@handleRegister');

/** HomeController */
Route::get('home', 'HomeController@index');
Route::get('search', 'HomeController@search');

/** OrderController */
Route::get('order', 'OrderController@create');
Route::get('history', 'OrderController@index');

/** ReviewController */
Route::get('review', 'ReviewController@create');
Route::post('review', 'ReviewController@store');

/** UserController */
Route::get('profile', 'UserController@profile');
Route::get('profile/edit', 'UserController@edit');
Route::put('profile/edit', 'UserController@update');

/** API */
Route::post('apis/create-order', 'CreateOrder');
Route::get('apis/validate-email', 'ValidateEmail');
Route::get('apis/validate-username', 'ValidateUsername');

//Experimental
Route::get('testservice', 'SoapServiceController');
