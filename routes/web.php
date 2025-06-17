<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Efiling\CaseDocumentController;
use App\Http\Controllers\Efiling\CaseFileController;
use App\Http\Controllers\Efiling\CasePaymentController;
use App\Http\Controllers\Efiling\PetitionerController;
use App\Http\Controllers\Efiling\RespondentController;
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

Route::view('/drafts', 'test');

// User routes {{{1
// Authentication {{{2
Route::prefix('user/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showUserLoginPage'])->name('user.auth.login.form');
    Route::post('/login', [LoginController::class, 'loginUser'])->name('user.auth.login.attempt');
    Route::post('/logout', [LoginController::class, 'logoutUser'])->middleware(['auth', PreventBackHistory::class])->name('user.auth.logout');
    Route::get('/register', [RegisterController::class, 'showUserRegisterPage'])->name('user.auth.register.form');
    Route::post('/register', [RegisterController::class, 'registerUser'])->name('user.auth.register.attempt');
});
// 2}}}

// Dashboard {{{2
Route::get('user/dashboard', [UserDashboardController::class, 'getCaseCounts'])->middleware(['auth'])->name('user.dashboard');
// Case Indexing {{{3
Route::prefix('user/cases')->middleware(['auth'])->group(function () {
    Route::get('/check_case_status', [UserDashboardController::class, 'checkCaseStatus'])->middleware(['auth'])->name('user.cases.check_case_status');
    Route::get('/get_cases/{case_status}', [UserDashboardController::class, 'indexCases'])->name('user.cases.get_cases');
    Route::get('/get_cases/drafts/continue/{case_file_id}', [UserDashboardController::class, 'continueDraftCase'])->name('user.cases.draft.continue');
});
// 3}}}
// 2}}}

// Filing routes for original application {{{2
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
});
// 2}}}
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
