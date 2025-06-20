<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    public function showUserRegisterPage(): View {
        return view('auth.register.user-register-page');
    }

    public function registerUser(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'middle_name' => 'nullable|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|string|email|max:50|unique:users,email',
            'alternate_email' => 'nullable|string|email|max:50',
            'mobile_no' => 'required|string|size:10|regex:/^[0-9]{10}$/|unique:users,mobile_no',
            'password' => 'required|string|min:8|confirmed',
            'secure_pin' => 'nullable|string|max:12',
            'question' => 'nullable|integer',
            'answer' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);
        $user->sendEmailVerificationNotification();

        return to_route('verification.notice', ['email' => $user->email]);
    }
}
