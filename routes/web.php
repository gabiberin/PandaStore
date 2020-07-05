<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', 'ProductController@index');

Route::resource('products', 'ProductController');

Route::resource('categories', 'CategoryController');

Route::get('/checkout', 'CheckoutController@create');
Route::post('/checkout', 'CheckoutController@store');

Route::delete('/customers/{id}', 'HomeController@deleteCustomer');

Route::resource('cart', 'CartController');

Route::get('/home', 'HomeController@index')->name('home');
