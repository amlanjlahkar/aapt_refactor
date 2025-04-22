<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showLoginForm(): View
    {
        return view('ui.user-login');
    }

    public function showRegistrationForm(): View
    {
        return view('ui.user-register');
    }

    public function registerUser(Request $request): RedirectResponse
    {
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

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('user.dashboard')
                ->with('success', 'User registered successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to register user. Please try again.')
                ->withInput();
        }
    }
}
