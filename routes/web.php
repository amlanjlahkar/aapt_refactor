<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
