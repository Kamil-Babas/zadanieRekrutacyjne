<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

// Public Routes (Guest Only)
Route::middleware('guest')->group(function () {

    // show login form
    Route::get('/login', [AuthController::class, 'showLoginView'])->name('login');

    // show register form
    Route::get('/register', [AuthController::class, 'showRegisterView']);

    // register user
    Route::post('/register', [AuthController::class, 'registerUser']);

    // login user
    Route::post('/login', [AuthController::class, 'authenticate']);

});

// Protected Routes (Authenticated Users Only)
Route::middleware('auth')->group(function () {

    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // index
    Route::get('/', fn() => view('welcome'));

    // excel upload form view
    Route::get('/excel/load', [ExcelController::class, 'loadExcelView']);

    // parse excel file
    Route::post('/excel/parse', [ExcelController::class, 'parseExcel']);

});

