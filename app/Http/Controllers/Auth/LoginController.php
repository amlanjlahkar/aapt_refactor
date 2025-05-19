<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAdminRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginPage(): View {
        return view('auth.login.login-page');
    }

<<<<<<< HEAD

    //User login
=======
    // User {{{1
>>>>>>> 80c7f37 (feat: Initial admin logic)
    public function showUserLoginPage(): View {
        return view('auth.login.user-login-page');
    }

    public function loginUser(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], true)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $username = implode(' ', array_filter([$user->first_name, $user->middle_name, $user->last_name]));
            $request->session()->put('user', $username);

            return to_route('user.dashboard');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logoutUser(Request $request): RedirectResponse {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
<<<<<<< HEAD

    //Admin login
=======
    // 1}}}

    // Admin {{{1
>>>>>>> 80c7f37 (feat: Initial admin logic)
    public function showAdminLoginPage(): View {
        return view('auth.login.admin-login-page');
    }

<<<<<<< HEAD
    public function adminLoginAttempt(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);
    
        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], true)) {
            $request->session()->regenerate();
    
            $admin = Auth::guard('admin')->user();
            $adminName = $admin->name;
            $request->session()->put('admin', $adminName);
    
            return to_route('admin.dashboard');
        }
    
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logoutAdmin(Request $request): RedirectResponse {
        Auth::guard('admin')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('admin.auth.login.form');
    }
    

=======
    public function loginAdmin(LoginAdminRequest $request): RedirectResponse {
        $credentials = $request->validated();

        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 'active',
        ], true)) {
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $request->session()->put('admin', $admin->name);
            return to_route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records or the account has been deactivated',
        ])->onlyInput('email');
    }
    // 1}}}
>>>>>>> 80c7f37 (feat: Initial admin logic)
}
