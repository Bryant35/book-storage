<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', 'App\Http\Controllers\BookController@index');

Route::view('/login', 'login.login');

Route::prefix('/validate')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
});

Route::prefix('book')->group(function () {
    Route::get('/view', 'App\Http\Controllers\BookController@index');

    Route::middleware(['can:create book'])->group(function () {
        Route::get('/create', 'App\Http\Controllers\BookController@bookCreateView');
        Route::post('/save','App\Http\Controllers\BookController@addBook');
    });

    Route::get('/edit', 'App\Http\Controllers\BookController@bookEditView');
    Route::post('/update', 'App\Http\Controllers\BookController@updateBook');
});

Route::prefix('/author')->group(function () {
    Route::get('/', function () {
        return redirect('/author/view');
    });
    Route::get('/view','App\Http\Controllers\AuthorController@viewAuthor');
    Route::get('/book','App\Http\Controllers\AuthorController@viewBookByAuthor');
    Route::get('/edit','App\Http\Controllers\AuthorController@editViewAuthor');
    Route::post('/update','App\Http\Controllers\AuthorController@updateAuthor');
    Route::get('/create', function(){
        return view('author.create-author');
    });
    Route::post('/save','App\Http\Controllers\AuthorController@newAuthor');
});

Route::prefix('category')->group(function () { 
    Route::get('/view','App\Http\Controllers\CategoryController@viewCategory');
    Route::get('/book','App\Http\Controllers\CategoryController@viewBookByCategory');
    Route::get('/edit','App\Http\Controllers\CategoryController@editViewCategory');
    Route::post('/update','App\Http\Controllers\CategoryController@updateCategory');
    Route::get('/create', function(){
        return view('category.create-category');
    });
    Route::post('/save','App\Http\Controllers\CategoryController@addCategory');
}); 

Route::prefix('/user')->group(function () {
    Route::get('','App\Http\Controllers\UserController@index');
    Route::get('/create', function(){
        return view('user-management.create-user');
    });
    Route::post('/save','App\Http\Controllers\UserController@addUser');
    Route::get('/edit','App\Http\Controllers\UserController@editViewUser');
    Route::post('/update','App\Http\Controllers\UserController@updateUser');
});

Route::prefix('/role')->group(function () {
    Route::get('','App\Http\Controllers\RoleController@indexRoles');
    Route::get('/edit','App\Http\Controllers\RoleController@editViewRole');
    Route::get('/create', function(){
        return view('user-management.create-role');
    });
});