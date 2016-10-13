<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/home/edit', 'HomeController@edit');
Route::post('/home/edit', 'HomeController@update');

Route::get('/products', 'ProductController@index');
Route::get('/products/b/{brand}', 'ProductController@index');
Route::post('/products', 'ProductController@filter');
Route::get('/products/create', 'ProductController@create');
Route::post('/products/create', 'ProductController@store');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/products/{id}/edit', 'ProductController@edit');
Route::post('/products/{id}/edit', 'ProductController@update');
Route::get('/products/{id}/delete', 'ProductController@destroy');