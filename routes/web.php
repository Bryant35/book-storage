<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\BookController@index');

Route::view('/login', 'login.login');

Route::prefix('/validate')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
});

Route::prefix('book')->group(function () {
    Route::get('/edit', 'App\Http\Controllers\BookController@edit');
});
