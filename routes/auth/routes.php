<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/profile/reports/{fileType}', 'App\Http\Controllers\UserController@reports')->name('user.reports');

    Route::get('/profile', 'App\Http\Controllers\UserController@index')->name('user.index');

    Route::post('/reviews/save', 'App\Http\Controllers\ReviewController@save')->name('review.save');

});
