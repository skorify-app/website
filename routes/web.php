<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;



# Main page
Route::get('/', [IndexController::class, 'index'])->name('index');

# Log in routes
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

# Log out route
Route::get('/logout', [LogoutController::class, 'destroy'])->name('logout');

# Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


Route::get('/staff/dashboard', function() {
    return "Welcome Staff!";
})->middleware('auth');

Route::middleware('authCheck')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('Admin.dasboard');
    });

    Route::get('/staff/dashboard', function () {
        return view('staff.index');
    });
});



// Staff Routes
Route::get('/index', function () {
    return view('staff.index');
});

Route::get('/subtes', function () {
    return view('staff.subtes');
});


// Profile page for staff
Route::get('/profile', function () {
    return view('Staff.profile');
});

// Simple logout route: clear session and redirect to login/main page
Route::get('/logout', function () {
    // If Auth is available, attempt logout; otherwise flush session
    if (class_exists(\Illuminate\Support\Facades\Auth::class)) {
        \Illuminate\Support\Facades\Auth::logout();
    }
    session()->flush();
    return redirect('/');
});

// Admin Routes
Route::get('/admin/tambahadmin', function () {
    return view('Admin.tambahadmin');
});

// Subtes Routes
// Route::resource('subtes', SubtesController::class);
