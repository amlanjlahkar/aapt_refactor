<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/home', 'ui/home')->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');

// User Authentication Routes
Route::prefix('user')->group(function () {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserController::class, 'loginUser'])->name('user.login.submit');
    Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/register', [UserController::class, 'registerUser'])->name('user.register.submit');
});
