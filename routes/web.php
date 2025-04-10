<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\BookController@index');

Route::view('/login', 'login.login');

Route::prefix('/validate')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
});

Route::prefix('book')->group(function () {
    Route::get('/view', 'App\Http\Controllers\BookController@index');
    Route::get('/edit', 'App\Http\Controllers\BookController@bookEditView');
    // Route::get('/editForm', function(){
    //     return view('book.edit-book');
    // });
    Route::post('/update', 'App\Http\Controllers\BookController@updateBook');
});

Route::prefix('/author')->group(function () {
    Route::get('/view','App\Http\Controllers\AuthorController@viewAuthor');
    Route::get('/book','App\Http\Controllers\AuthorController@viewBookByAuthor');
});