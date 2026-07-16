<?php

use Illuminate\Support\Facades\Route;

Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::delete('/cart', 'App\Http\Controllers\CartController@delete')->name('cart.delete');
Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name('cart.add');

Route::middleware('auth')->group(function () {
    Route::post('/cart/purchase', 'App\Http\Controllers\CartController@purchase')->name('cart.purchase');
});
