<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Efiling\CaseDocumentController;
use App\Http\Controllers\Efiling\CaseFileController;
use App\Http\Controllers\Efiling\CasePaymentController;
use App\Http\Controllers\Efiling\PetitionerController;
use App\Http\Controllers\Efiling\RespondentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::get('/refresh-captcha', function () {
    return captcha_img('flat');
});

/* User routes */
Route::view('user/dashboard', 'user/dashboard')->name('user.dashboard');
Route::prefix('user/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showUserLoginPage'])->name('user.auth.login.form');
    Route::post('/login', [LoginController::class, 'loginUser'])->name('user.auth.login.attempt');
    Route::post('/logout', [LoginController::class, 'logoutUser'])->name('user.auth.logout');
    Route::get('/register', [RegisterController::class, 'showUserRegisterPage'])->name('user.auth.register.form');
    Route::post('/register', [RegisterController::class, 'registerUser'])->name('user.auth.register.attempt');
});

// Filing routes for original application
Route::prefix('user/efiling/register')->group(function () {
    $steps = [
        1 => [
            'view' => 'case-file',
            'controller' => CaseFileController::class,
        ],
        2 => [
            'view' => 'petitioner-info',
            'controller' => PetitionerController::class,
        ],
        3 => [
            'view' => 'respondent-info',
            'controller' => RespondentController::class,
        ],
        4 => [
            'view' => 'document',
            'controller' => CaseDocumentController::class,
        ],
        5 => [
            'view' => 'payment',
            'controller' => CasePaymentController::class,
        ],
    ];

    foreach ($steps as $step => $info) {
        Route::get("/step{step}/{$info['view']}/{case_file_id?}", [$info['controller'], 'create'])
            ->name("user.efiling.register.step{$step}.create");

        Route::get("/{$info['view']}/edit/{case_file_id?}", [$info['controller'], 'edit'])
            ->name("user.efiling.register.step{$step}.edit");

        Route::post("/step{step}/{$info['view']}/{case_file_id?}", [$info['controller'], 'store'])
            ->name("user.efiling.register.step{$step}.attempt");
    }

    Route::get('/review', [CaseFileController::class, 'show'])->name('user.efiling.register.review');
    Route::get('/{case_file_id}/generate_case_file_doc', [CaseFileController::class, 'generatePdf'])->name('user.efiling.register.genPdf');

    Route::get('/case-files/{case_file_id}/edit', [CaseFileController::class, 'edit'])
        ->name('case-files.edit');

    Route::get('/petitioners/{case_file_id}/edit', [PetitionerController::class, 'edit'])
        ->name('petitioners.edit');

    Route::get('/respondents/{case_file_id}/edit', [RespondentController::class, 'edit'])
        ->name('respondents.edit');

    Route::get('/documents/{case_file_id}/edit', [CaseDocumentController::class, 'edit'])
        ->name('documents.edit');

    Route::get('/payments/{case_file_id}/edit', [CasePaymentController::class, 'edit'])
        ->name('payments.edit');
});

/* Mail verficaiton */
Route::view('/email_verify_notice', 'mail/verify-notice')->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/user/auth/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
