<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', 'App\Http\Controllers\BookController@index');

Route::view('/login', 'login.login');

Route::prefix('/validate')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
});


/**
 * Book Pages
 */
Route::prefix('book')->group(function () {
    // Route::middleware(['can:view book'])->group(function () {
        Route::get('/view', 'App\Http\Controllers\BookController@index');
    // });

    Route::middleware(['can:create book'])->group(function () {
        Route::get('/create', 'App\Http\Controllers\BookController@bookCreateView');
        Route::post('/save','App\Http\Controllers\BookController@addBook');
    });

    Route::middleware(['can:edit book'])->group(function () {
        Route::get('/edit', 'App\Http\Controllers\BookController@bookEditView');
        Route::post('/update', 'App\Http\Controllers\BookController@updateBook');
    });
});

/**
 * Author Pages
 */
Route::prefix('/author')->group(function () {
    Route::middleware(['can:view author'])->group(function () {
        Route::get('/', function () {
            return redirect('/author/view');
        });
        Route::get('/view','App\Http\Controllers\AuthorController@viewAuthor');
    });

    Route::middleware(['can:view book'])->group(function () {
        Route::get('/book','App\Http\Controllers\AuthorController@viewBookByAuthor');
    });

    Route::middleware(['can:edit author'])->group(function () {
        Route::get('/edit','App\Http\Controllers\AuthorController@editViewAuthor');
        Route::post('/update','App\Http\Controllers\AuthorController@updateAuthor');
    });

    Route::middleware(['can:create author'])->group(function () {
        Route::get('/create', function(){
            return view('author.create-author');
        });
        Route::post('/save','App\Http\Controllers\AuthorController@newAuthor');
    });
});


/**
 * Category Pages
 */
Route::prefix('category')->group(function () { 
    Route::middleware(['can:view category'])->group(function () {
        Route::get('/view','App\Http\Controllers\CategoryController@viewCategory');
    });

    Route::middleware(['can:view book'])->group(function () {
        Route::get('/book','App\Http\Controllers\CategoryController@viewBookByCategory');
    });

    Route::middleware(['can:edit category'])->group(function () {
        Route::get('/edit','App\Http\Controllers\CategoryController@editViewCategory');
        Route::post('/update','App\Http\Controllers\CategoryController@updateCategory');
    });

    Route::middleware(['can:create category'])->group(function () {
        Route::get('/create', function(){
            return view('category.create-category');
        });
        Route::post('/save','App\Http\Controllers\CategoryController@addCategory');
    }); 
}); 

/**
 * User Pages
 */
Route::prefix('/user')->group(function () {
    Route::middleware(['can:view user'])->group(function () {
        Route::get('','App\Http\Controllers\UserController@index');
    });

    Route::middleware(['can:create user'])->group(function () {
        Route::get('/create', function(){
            return view('user-management.create-user');
        });
        Route::post('/save','App\Http\Controllers\UserController@addUser');
    });

    Route::middleware(['can:edit user'])->group(function () {
        Route::get('/edit','App\Http\Controllers\UserController@editViewUser');
        Route::post('/update','App\Http\Controllers\UserController@updateUser');
    });

    //Create Guest Account
    Route::prefix('/guest')->group(function () {
        Route::get('/create', function(){
            return view('user-management.create-guest-user');
        });
        Route::post('/save','App\Http\Controllers\UserController@createGuestUser');
    });
});

/**
 * Role Pages
 */
Route::prefix('/role')->group(function () {
    Route::middleware(['can:view role'])->group(function () {
        Route::get('','App\Http\Controllers\RoleController@indexRoles')->name('role');
    });

    Route::middleware(['can:edit role'])->group(function () {
        Route::get('/edit','App\Http\Controllers\RoleController@editViewRole');
        Route::post('/update', 'App\Http\Controllers\RoleController@updateRole');
    });

    Route::middleware(['can:create role'])->group(function () {
        Route::get('/create','App\Http\Controllers\RoleController@addRoleView');
        Route::post('/add','App\Http\Controllers\RoleController@addRole');
    });
});