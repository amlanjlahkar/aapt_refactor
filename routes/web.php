<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login.show');

// user routes
Route::prefix('user')->group(function () {
    Route::get('/login', [LoginController::class, 'showUserLoginPage'])->name('user.login');
    Route::post('/login', [LoginController::class, 'loginUser'])->name('user.login.submit');
    Route::get('/register', [RegisterController::class, 'showUserRegisterPage'])->name('user.register');
    Route::post('/register', [RegisterController::class, 'registerUser'])->name('user.register.submit');
    Route::view('/dashboard', 'user-dashbboard')->name('user.dashboard');
});

// mail routes
Route::view('/mail_verify_notice', 'mail/verify-notice')->name('mail_verify_notice');
