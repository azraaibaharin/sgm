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
Route::get('/home/edit', 'HomeController@edit')->middleware('auth');
Route::post('/home/edit', 'HomeController@update')->middleware('auth');

// Products
Route::get('/products', 'ProductController@index');
Route::get('/products/b/{brand}', 'ProductController@index');
Route::get('/products/b/{brand}/c/{category}', 'ProductController@index');
Route::post('/products', 'ProductController@filter');
Route::get('/products/create', 'ProductController@create')->middleware('auth');
Route::post('/products/create', 'ProductController@store')->middleware('auth');
Route::get('/products/import', 'ProductController@import')->middleware('auth');
Route::post('/products/import', 'ProductController@store2')->middleware('auth');
Route::get('/products/{id}', 'ProductController@show');
Route::get('/products/{id}/edit', 'ProductController@edit')->middleware('auth');
Route::post('/products/{id}/edit', 'ProductController@update')->middleware('auth');
Route::post('/products/delete', 'ProductController@destroy')->middleware('auth');

// Articles
Route::get('articles', 'ArticleController@index');
Route::get('articles/create', 'ArticleController@create')->middleware('auth');
Route::post('articles/create', 'ArticleController@store')->middleware('auth');
Route::get('articles/{id}', 'ArticleController@show');
Route::get('articles/{id}/edit', 'ArticleController@edit')->middleware('auth');
Route::post('articles/{id}/edit', 'ArticleController@update')->middleware('auth');
Route::post('articles/delete', 'ArticleController@destroy')->middleware('auth');

// Testimonials
Route::get('testimonials', 'TestimonialController@index');
Route::get('testimonials/b/{brand}', 'TestimonialController@index');
Route::post('testimonials', 'TestimonialController@filter');
Route::get('testimonials/create', 'TestimonialController@create')->middleware('auth');
Route::post('testimonials/create', 'TestimonialController@store')->middleware('auth');
Route::get('testimonials/{id}', 'TestimonialController@show');
Route::get('testimonials/{id}/edit', 'TestimonialController@edit')->middleware('auth');
Route::post('testimonials/{id}/edit', 'TestimonialController@update')->middleware('auth');
Route::post('testimonials/delete', 'TestimonialController@destroy')->middleware('auth');

// Stores
Route::get('stores', 'StoreController@index');
Route::post('stores', 'StoreController@filter');
Route::get('stores/create', 'StoreController@create')->middleware('auth');
Route::post('stores/create', 'StoreController@store')->middleware('auth');
Route::get('stores/{id}', 'StoreController@show');
Route::get('stores/{id}/edit', 'StoreController@edit')->middleware('auth');
Route::post('stores/{id}/edit', 'StoreController@update')->middleware('auth');
Route::post('stores/delete', 'StoreController@destroy')->middleware('auth');

// Warranties
Route::get('warranties', 'WarrantyController@index')->middleware('auth');
Route::get('warranties/create', 'WarrantyController@create');
Route::post('warranties/create', 'WarrantyController@store');
Route::get('warranties/{id}', 'WarrantyController@show');
Route::get('warranties/{id}/edit', 'WarrantyController@edit')->middleware('auth');
Route::post('warranties/{id}/edit', 'WarrantyController@update')->middleware('auth');
Route::post('warranties/delete', 'WarrantyController@destroy')->middleware('auth');

// Cart
Route::resource('cart', 'CartController', ['only' => ['index', 'store', 'update', 'destroy']]);
Route::get('cart/{id}/add', 'CartController@add');
Route::get('cart/{id}/remove', 'CartController@remove');
Route::get('cart/empty', 'CartController@empty');
Route::get('payment', 'CartController@payment');
Route::post('payment/response', 'CartController@paymentResponse');
Route::post('payment/responseBE', 'CartController@paymentResponseBE');

// Coupons
Route::get('coupons', 'CouponController@index')->middleware('auth');
Route::get('coupons/create', 'CouponController@create')->middleware('auth');
Route::post('coupons/create', 'CouponController@store')->middleware('auth');
Route::get('coupons/{id}', 'CouponController@show')->middleware('auth');
Route::get('coupons/{id}/edit', 'CouponController@edit')->middleware('auth');
Route::put('coupons/{id}', 'CouponController@update')->middleware('auth');
Route::delete('coupons/{id}', 'CouponController@destroy')->middleware('auth');