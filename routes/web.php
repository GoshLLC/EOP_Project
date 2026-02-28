<?php

use Illuminate\Support\Facades\Route;

// Import the controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\SearchController;

// Default Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Redirect to Home Page
Route::get('/', function () { return Redirect::to('/home');
});

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Logout Route
Route::POST('logout', [LoginController::class, 'logout'])->name('logout');

// Home Route
Route::get('home', [HomeController::class, 'index'])->name('home');

// Profile Route
Route::get('profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

//Protect Admin Route
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/create-user', [UserManagementController::class, 'create'])->name('admin.create');
        Route::post('/create-user', [UserManagementController::class, 'store']);

        Route::delete('/user/{id}', [UserManagementController::class, 'destroy'])->name('admin.user.delete');

    });

//Search Route
Route::get('/search', [SearchController::class, 'search'])->name('search');

?>