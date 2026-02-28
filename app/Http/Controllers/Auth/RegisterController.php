<?php

namespace App\Http\Controllers\Auth;

use App\Models\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('layouts.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:accounts',
            'email' => 'required|string|email|max:100|unique:accounts',
            'password' => 'required|string|min:8',
        ]);

        // Create a new account
        $account = Account::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        // Authenticate the new account
        Auth::login($account);

        // Redirect to homepage
        return redirect('home');
    }
}

?>