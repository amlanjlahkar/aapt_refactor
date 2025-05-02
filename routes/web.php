<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::get('/refresh-captcha', function () {
    return captcha_img('flat');
});

/* User routes */
Route::prefix('user/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showUserLoginPage'])->name('user.auth.login.form');
    Route::post('/login', [LoginController::class, 'loginUser'])->name('user.auth.login.attempt');
    Route::post('/logout', [LoginController::class, 'logoutUser'])->name('user.auth.logout');
    Route::get('/register', [RegisterController::class, 'showUserRegisterPage'])->name('user.auth.register.form');
    Route::post('/register', [RegisterController::class, 'registerUser'])->name('user.auth.register.attempt');
});

Route::prefix('user')->group(function () {
    Route::view('/dashboard', 'user/dashboard')->middleware(['auth', 'verified'])->name('user.dashboard');
});

/* Mail verficaiton */
Route::view('/email_verify_notice', 'mail/verify-notice')->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/user/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
