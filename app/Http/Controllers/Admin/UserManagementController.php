<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\UserManagementController;

class UserManagementController extends Controller
{
    public function create()
    {
        $users = \App\Models\User::all();
        return view('admin.create-user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:accounts',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,staff,volunteer,user'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'registered' => now(),
        ]);


        return redirect()->back()->with('success', 'User created successfully');
    }

public function destroy($id)
{
    $user = User::findOrFail($id);

    // Prevent admin From Deleting admin Account
    if ($user->id === auth()->id()) {
        return back()->with('error', 'You cannot delete your own account.');
    }

    if ($user->id === 1) {
        return back()->with('error', 'The primary system administrator cannot be deleted.');
    }

    $user->delete();

    return back()->with('success', 'User deleted successfully.');
}

}