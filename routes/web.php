<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SubtestController;
use Illuminate\Support\Facades\Route;



# Main page
Route::get('/', [IndexController::class, 'index'])->name('index');

# Log in routes
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

# Log out route
Route::get('/logout', [LogoutController::class, 'destroy'])->name('logout');

# Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

# Subtest
Route::get('/subtest', [SubtestController::class, 'index'])
    ->name('subtest.index')->middleware('auth');
Route::put('/subtest', [SubtestController::class, 'store'])
    ->name('subtest.store')->middleware('auth');
Route::delete('/subtest/{subtest_id}', [SubtestController::class, 'delete'])
    ->name('subtest.delete')->middleware('auth');



Route::get('/admin/tambahadmin', function () {
    return view('Admin.tambahadmin');
});

// Subtes Routes
// Route::resource('subtes', SubtesController::class);
