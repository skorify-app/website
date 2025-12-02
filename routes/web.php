<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SubtestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

# Main page
Route::get('/', [IndexController::class, 'index'])->name('index');

# Login
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

# Logout (POST)
Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

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

# Profile Page
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile')->middleware('auth');

# Profile Updates (AJAX)
Route::post('/profile/update-name', [ProfileController::class, 'updateName'])
    ->middleware('auth');

Route::post('/profile/update-email', [ProfileController::class, 'updateEmail'])
    ->middleware('auth');

Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])
    ->middleware('auth');

# Staff & Admin Views
Route::get('/staff/pengerjaan', fn() => view('Staff.pengerjaan'));
Route::get('/admin/pengerjaan', fn() => view('Admin.pengerjaan'))
    ->name('admin.pengerjaan');

Route::get('/admin/tambahadmin', fn() => view('Admin.tambahadmin'));

Route::get('/subtes', fn() => view('staff.subtes'));
