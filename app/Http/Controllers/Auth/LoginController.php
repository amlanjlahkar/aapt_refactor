<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginPage(): View {
        return view('auth.login.login-page');
    }

    // User {{{1
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

    // 1}}}
    // Admin {{{1
    public function showAdminLoginPage(): View {
        return view('auth.login.admin-login-page');
    }

    public function loginAdmin(LoginAdminRequest $request): RedirectResponse {
        $credentials = $request->validated();

        // if (Auth::guard('admin')->attempt([
        //     'email' => $credentials['email'],
        //     'password' => $credentials['password'],
        //     'status' => 'active',
        // ], true)) {
        //     $request->session()->regenerate();

        //     $admin = Auth::guard('admin')->user();
        //     $request->session()->put('admin', $admin->name);

        //     return to_route('admin.dashboard');
        // }

        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 'active',
        ])) {
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $request->session()->put('admin', $admin->name);

            // Check if user has the scrutiny-admin role
            if ($admin->hasRole('scrutiny-admin')) {
                return to_route('scrutiny.dashboard'); // Change this to scrutiny dashboard route
            }

            return to_route('admin.dashboard');
        }


        return back()->withErrors([
            'login' => 'The provided credentials do not match our records or the account has been deactivated',
        ])->onlyInput('email');
    }

    public function logoutAdmin(Request $request): RedirectResponse {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    // 1}}}
}
