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

Auth::routes();

// Home
Route::get('/', 'HomeController@index');
Route::post('/contact', 'HomeController@contact');
Route::get('/home', 'HomeController@index');
Route::get('/home/edit', 'HomeController@edit');
Route::post('/home/edit', 'HomeController@update');

// Products
Route::get('/products', 'ProductController@index');
Route::get('/products/b/{brand}', 'ProductController@index');
Route::post('/products', 'ProductController@filter');
Route::get('/products/create', 'ProductController@create');
Route::post('/products/create', 'ProductController@store');
Route::get('/products/import', 'ProductController@import');
Route::post('/products/import', 'ProductController@store2');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/products/{id}/edit', 'ProductController@edit');
Route::post('/products/{id}/edit', 'ProductController@update');
Route::post('/products/delete', 'ProductController@destroy');

// Articles
Route::get('articles', 'ArticleController@index');
Route::get('articles/create', 'ArticleController@create');
Route::post('articles/create', 'ArticleController@store');
Route::get('articles/{id}', 'ArticleController@show');
Route::get('articles/{id}/edit', 'ArticleController@edit');
Route::post('articles/{id}/edit', 'ArticleController@update');
Route::post('articles/delete', 'ArticleController@destroy');

// Testimonials
Route::get('testimonials', 'TestimonialController@index');
Route::post('testimonials', 'TestimonialController@filter');
Route::get('testimonials/create', 'TestimonialController@create');
Route::post('testimonials/create', 'TestimonialController@store');
Route::get('testimonials/{id}', 'TestimonialController@show');
Route::get('testimonials/{id}/edit', 'TestimonialController@edit');
Route::post('testimonials/{id}/edit', 'TestimonialController@update');
Route::post('testimonials/delete', 'TestimonialController@destroy');


