<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//show login form
Route::get('/login', [AuthController::class, 'showLoginView'])->name('login');
//show register form
Route::get('/register', [AuthController::class, 'showRegisterView']);

//register user
Route::post('/register', [AuthController::class, 'registerUser']);
//login user
Route::post('/login', [AuthController::class, 'authenticate']);
//logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

//index
Route::get('/', fn() => view('welcome'))->middleware('auth');
