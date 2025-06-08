<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Efiling\CaseDocumentController;
use App\Http\Controllers\Efiling\CaseFileController;
use App\Http\Controllers\Efiling\CasePaymentController;
use App\Http\Controllers\Efiling\PetitionerController;
use App\Http\Controllers\Efiling\RespondentController;
use App\Http\Controllers\Internal\ScrutinyController;
use App\Http\Controllers\Internal\Department\DepartmentUserController;
use App\Http\Controllers\Internal\Department\DepartmentUserRoleController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/login', [LoginController::class, 'showLoginPage'])->name('login');
Route::get('/refresh-captcha', function () {
    return captcha_img('flat');
});

// User routes {{{1
Route::get('user/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth'])->name('user.dashboard');
Route::prefix('user/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showUserLoginPage'])->name('user.auth.login.form');
    Route::post('/login', [LoginController::class, 'loginUser'])->name('user.auth.login.attempt');
    Route::post('/logout', [LoginController::class, 'logoutUser'])->middleware(['auth', PreventBackHistory::class])->name('user.auth.logout');
    Route::get('/register', [RegisterController::class, 'showUserRegisterPage'])->name('user.auth.register.form');
    Route::post('/register', [RegisterController::class, 'registerUser'])->name('user.auth.register.attempt');
});

// Filing routes for original application
Route::prefix('user/cases')->middleware(['auth'])->group(function () {
    Route::get('/draft', [UserDashboardController::class, 'indexDraftCases'])->name('user.cases.draft');
    Route::get('/draft/continue/{case_file_id}', [UserDashboardController::class, 'continueDraftCase'])->name('user.cases.draft.continue');
    Route::get('/pending', [UserDashboardController::class, 'indexPendingCases'])->name('user.cases.pending');
});
Route::post('user/efiling/{case_file_id}/submit', [CaseFileController::class, 'showSubmitNotice'])->middleware(['auth'])->name('user.efiling.submit');
Route::post('user/efiling/{case_file_id}/case_pdf', [CaseFileController::class, 'generatePdf'])->name('user.efiling.generate_case_pdf');
Route::prefix('user/efiling/register')->middleware(['auth', PreventBackHistory::class])->group(function () {
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
    Route::get('/summary/{case_file_id?}', [CaseFileController::class, 'generatePdf']); // only for testing

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
// 1}}}

// Admin routes {{{1
Route::view('admin/dashboard', 'admin.dashboard')->middleware('auth:admin')->name('admin.dashboard');

Route::prefix('admin/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showAdminLoginPage'])->name('admin.auth.login.form');
    Route::post('/login', [LoginController::class, 'loginAdmin'])->name('admin.auth.login.attempt');
    Route::post('/logout', [LoginController::class, 'logoutAdmin'])->middleware(['auth:admin', PreventBackHistory::class])->name('admin.auth.logout');
});

Route::prefix('admin/internal/dept')->middleware(['auth:admin', PreventBackHistory::class])->group(function () {
    Route::view('/', 'admin.internal.department.show')->name('admin.internal.dept.show');
    Route::get('/users', [DepartmentUserController::class, 'index'])->name('admin.internal.dept.users.index');
    Route::get('/users/create', [DepartmentUserController::class, 'create'])->name('admin.internal.dept.users.create');
    Route::post('/users/store', [DepartmentUserController::class, 'store'])->name('admin.internal.dept.users.store');
    Route::get('/roles', [DepartmentUserRoleController::class, 'index'])->name('admin.internal.dept.roles.index');
    Route::get('/roles/create', [DepartmentUserRoleController::class, 'create'])->name('admin.internal.dept.roles.create');
    Route::post('/roles/store', [DepartmentUserRoleController::class, 'store'])->name('admin.internal.dept.roles.store');
});
// 1}}}

// Mail verficaiton {{{1
Route::view('/email_verify_notice', 'mail.verify-notice')->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // mark email as verified

    return redirect('/user/auth/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification email has been sent successfully!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// 1}}}



// Scrutiny routes {{{1
Route::prefix('scrutiny')->middleware('auth:admin')->group(function () {
    Route::get('/', [ScrutinyController::class, 'index'])->name('scrutiny.dashboard');
    Route::get('/create/{caseFileId}', [ScrutinyController::class, 'create'])->name('scrutiny.create');
    Route::post('/store', [ScrutinyController::class, 'store'])->name('scrutiny.store');
    // Route::get('/cases/{caseFileId}', [ScrutinyController::class, 'show'])->name('cases.show');
});
// 1}}}
