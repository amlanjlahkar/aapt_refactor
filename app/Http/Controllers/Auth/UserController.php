<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('ui.user-login');
    }

    public function showRegistrationForm()
    {
        return view('ui.user-register');
    }

    public function registerUser(Request $request)
    {
        // Add your registration logic here
        // Validate the request
        // Create the user
        // Redirect to appropriate page
    }
}
