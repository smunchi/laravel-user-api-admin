<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@login')->name('api.login');
    Route::post('register', 'RegisterController@store')->name('api.register.store');
});

Route::namespace('Config')->group(function () {
    Route::get('configs/fields', 'ConfigController@getFields')->name('api.config.field.index');
});

Route::middleware('auth:api')->group(function () {
    Route::get('products', 'Product\ProductController@index')->name('api.product.index');
});
