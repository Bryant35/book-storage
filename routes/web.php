<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::get('/', 'App\Http\Controllers\BookController@index');

Route::view('/login', 'login.login')->name('login');
Route::view('/forget-password', 'login.forget-password')->name('forgot-password');

Route::prefix('/validate')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('/forget-password', 'App\Http\Controllers\AuthController@forgetPassword');
});

/**
 * Password Reset from email
 */
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/**
 * Book Pages
 */
Route::prefix('book')->group(function () {
    // Route::middleware(['can:view book'])->group(function () {
        Route::get('/view', 'App\Http\Controllers\BookController@index')->name('book.view');
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

/**
 * Profile Pages
 */
Route::prefix('/profile')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'viewProfile']);
    Route::post('/send-verification-email', [ProfileController::class, 'sendVerificationEmail']);
    Route::post('/update', [ProfileController::class, 'updateProfile']);
});

/**
 * Email Verification
 */
Route::prefix('email')->group(function () {
    Route::prefix('verify')->group(function () {
        Route::get('/', function () {
            return view('auth.verify-email')->middleware('auth')->name('verification.notice');;
        });

        Route::get('/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
        
            return redirect('/book/view')->with('verified', 'Email verified successfully!');
        })->middleware(['auth', 'signed'])->name('verification.verify');// This route is for the email verification link
    });

    Route::post('/verification-notification', function (Request $request) {
        
        $request->validate([
            'email' => 'required|email',
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Check if the email is already verified
        if ($user->hasVerifiedEmail() && $request->email === $user->email) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        // Update the user's email in the database
        $user->forceFill([
            'email' => $request->email
        ])->save(); // Save the new email

        // Send the email verification notification to the new email
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email sent to the new email address.']);
    })->name('verification.send');
    // Route::get('/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
    // Route::get('/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    // Route::post('/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
});

Route::get('/test-email', function () {
    // \Mail::raw('This is a test email', function ($message) {
    //     $message->to('bryantthauwrisan7@gmail.com')->subject('Test Email');
    // });
    auth()->user()->sendEmailVerificationNotification();
    return 'Test email sent!';
});