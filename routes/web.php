<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('ui/home');
});

Route::get('/internal/login', function () {
    return view('auth/internal/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');

// User Authentication Routes
Route::prefix('user')->group(function () {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.login');
    Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/register', [UserController::class, 'registerUser'])->name('user.register.submit');
});
