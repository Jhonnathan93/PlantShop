<?php

use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    Route::get('/admin', 'App\Http\Controllers\Admin\AdminHomeController@index')->name('admin.index');

    Route::get('/admin/plants', 'App\Http\Controllers\Admin\AdminPlantController@index')->name('admin.plant.index');
    Route::get('/admin/plants/create', 'App\Http\Controllers\Admin\AdminPlantController@create')->name('admin.plant.create');
    Route::post('/admin/plants/save', 'App\Http\Controllers\Admin\AdminPlantController@save')->name('admin.plant.save');
    Route::delete('/admin/plants/{id}/delete', 'App\Http\Controllers\Admin\AdminPlantController@delete')->name('admin.plant.delete');
    Route::get('/admin/plants/{id}/edit', 'App\Http\Controllers\Admin\AdminPlantController@edit')->name('admin.plant.edit');
    Route::put('/admin/plants/{id}', 'App\Http\Controllers\Admin\AdminPlantController@update')->name('admin.plant.update');
    Route::get('/admin/plants/{id}', 'App\Http\Controllers\Admin\AdminPlantController@show')->name('admin.plant.show');

    Route::get('/admin/guides/{id}/edit', 'App\Http\Controllers\Admin\AdminGuideController@edit')->name('admin.guide.edit');
    Route::get('/admin/guides', 'App\Http\Controllers\Admin\AdminGuideController@index')->name('admin.guide.index');
    Route::get('/admin/guides/create', 'App\Http\Controllers\Admin\AdminGuideController@create')->name('admin.guide.create');
    Route::post('/admin/guides/save', 'App\Http\Controllers\Admin\AdminGuideController@save')->name('admin.guide.save');
    Route::delete('/admin/guides/{id}/delete', 'App\Http\Controllers\Admin\AdminGuideController@delete')->name('admin.guide.delete');
    Route::put('/admin/guides/{id}', 'App\Http\Controllers\Admin\AdminGuideController@update')->name('admin.guide.update');
    Route::get('/admin/guides/{id}', 'App\Http\Controllers\Admin\AdminGuideController@show')->name('admin.guide.show');
});
