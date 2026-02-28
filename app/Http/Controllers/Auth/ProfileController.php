<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;                     // ← This line fixes it!
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Routing\Controllers\HasMiddleware;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated user details
        $account = Auth::user();

        // Return the profile view with the authenticated user details
        return view('layouts.profile', ['account' => $account]);
    }

    public function edit()
    {
        $account = auth()->user();
        return view('layouts.profile', ['account' => $account]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => ['sometimes', 'string', 'max:55'],
            'email' => ['required', 'email', 'max:55', 'unique:accounts,email,' . $user->id],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password'              => ['sometimes', 'confirmed', Password::defaults()],
                'password_confirmation' => ['sometimes'],
            ]);

            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
}
?>