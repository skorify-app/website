<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubtestController;
use Illuminate\Support\Facades\Route;



# Main page
Route::get('/', [IndexController::class, 'index'])->name('index');

# Log in routes
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

# Log out route
Route::get('/logout', [LogoutController::class, 'destroy'])->name('logout');

# Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')->middleware('auth');

# Subtest
Route::get('/subtest', [SubtestController::class, 'index'])
    ->name('subtest.index')->middleware('auth');

Route::post('/subtest', [SubtestController::class, 'store'])
    ->name('subtest.store')->middleware('auth');

Route::delete('/subtest/{subtest_id}', [SubtestController::class, 'delete'])
    ->name('subtest.delete')->middleware('auth');

Route::post('/subtest/update', [SubtestController::class, 'update'])
    ->name('subtest.update')->middleware('auth');

// Pengerjaan Soal (Staff)
 Route::get('/staff/pengerjaan', function () {
    return view('Staff.pengerjaan');
});

// Pengerjaan Soal (Admin)
Route::get('/admin/pengerjaan', function () {
    return view('Admin.pengerjaan');
})->name('admin.pengerjaan');


Route::get('/admin/tambahadmin', function () {
    return view('Admin.tambahadmin');
});

Route::get('/subtes', function () {
    return view('staff.subtes');
});

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index')->middleware('auth');

Route::post('/profile', [ProfileController::class, 'update'])
    ->name('profile.update')->middleware('auth');


// Subtes Routes
// Route::resource('subtes', SubtesController::class);
