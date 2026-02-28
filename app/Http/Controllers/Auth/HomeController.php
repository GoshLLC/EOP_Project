<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated account details
        $account = Auth::user();
        // Return the home view with the account details
        return view('layouts.home', ['account' => $account]);
    }
}

?>