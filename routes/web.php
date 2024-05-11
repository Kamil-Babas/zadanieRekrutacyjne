<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public Routes (Guest Only)
Route::middleware('guest')->group(function () {

    // show login form
    Route::get('/login', [AuthController::class, 'showLoginView'])->name('login');

    // show register form
    Route::get('/register', [AuthController::class, 'showRegisterView']);

    // register user
    Route::post('/auth/register', [AuthController::class, 'registerUser']);

    // login user
    Route::post('/auth/login', [AuthController::class, 'authenticate']);

});

// Protected Routes (Authenticated Users Only)
Route::middleware('auth')->group(function () {

    // logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // index
    Route::get('/', fn() => view('welcome'));

    // excel upload form view
    Route::get('/excel/load', [ExcelController::class, 'loadExcelView']);


    Route::prefix('api')->group(function () {

        // parse excel file
        Route::post('/excel/parse', [ExcelController::class, 'parseExcel']);

        // search product based on 'q' query parameter -> returns json
        Route::get('/products/search', [ProductController::class, 'searchProduct']);
    });

});

