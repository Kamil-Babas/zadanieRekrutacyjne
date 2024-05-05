<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// show login form
Route::get('/login', [AuthController::class, 'showLoginView'])->name('login');
// show register form
Route::get('/register', [AuthController::class, 'showRegisterView']);

// register user
Route::post('/register', [AuthController::class, 'registerUser']);
// login user
Route::post('/login', [AuthController::class, 'authenticate']);
// logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// index
Route::get('/', fn() => view('welcome'))->middleware('auth');
// excel upload form view
Route::get('/excel/load', [ExcelController::class, 'loadExcelView'])->middleware('auth');
// parse excel file
Route::post('/excel/parse', [ExcelController::class, 'parseExcel'])->middleware('auth');

