<?php

use Illuminate\Support\Facades\Route;

// Import the controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\WishListController;

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
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

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

// Animal Intake
Route::middleware(['auth'])->group(function () {
    // Show intake page
    Route::get('/animalintake', [AnimalController::class, 'index'])->name('animals.index');

    // Handle form submission
    Route::post('/animalintake', [AnimalController::class, 'store'])->name('animals.store');
});

// Animal Delete
Route::middleware(['auth'])->group(function () {

    Route::delete('/animalintake/{id}', [AnimalController::class, 'destroy'])
        ->name('animals.destroy');

});

// Animal Edit
Route::middleware(['auth'])->group(function () {

    Route::get('/animalintake/{id}/edit', [AnimalController::class, 'edit'])
        ->name('animals.edit');

    Route::put('/animalintake/{id}', [AnimalController::class, 'update'])
        ->name('animals.update');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishListController::class, 'index'])
        ->name('wishlist.index');

    Route::post('/wishlist/{id}', [WishListController::class, 'store'])
        ->name('wishlist.store');

    Route::delete('/wishlist/{id}', [WishListController::class, 'destroy'])
        ->name('wishlist.destroy');
});

// Animal Deletion Request
Route::middleware(['auth'])->group(function () {
    Route::post('/animal/{id}/delete-request', [AnimalController::class, 'requestDeletion'])
        ->name('animal.delete.request');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/deletion-requests', [AnimalController::class, 'deletionRequests'])
        ->name('admin.deletion.requests');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::post('/admin/deletion/{id}/approve', [AnimalController::class, 'approveDeletion'])
        ->name('deletion.approve');

    Route::post('/admin/deletion/{id}/reject', [AnimalController::class, 'rejectDeletion'])
        ->name('deletion.reject');
});
?>