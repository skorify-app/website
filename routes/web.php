<?php

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\SubtestController;
use App\Models\Account;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;



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

# Manage staff accounts
Route::get('/staff', [StaffController::class, 'index'])
    ->name('staff.index')->middleware('auth');

Route::post('/staff', [StaffController::class, 'store'])
    ->name('staff.store')->middleware('auth');

Route::post('/staff/update', [StaffController::class, 'update'])
    ->name('staff.update')->middleware('auth');

Route::delete('/staff/{staff_id}', [StaffController::class, 'destroy'])
    ->name('staff.destroy')->middleware('auth');



// Pengerjaan Soal (Staff)
 Route::get('/staff/pengerjaan', function () {
    return view('Staff.pengerjaan');
});

// Pengerjaan Soal (Admin)

Route::get('/admin/pengerjaan/{subtest_id}', [ExamController::class, 'index'])
    ->name('pengerjaan')
    ->middleware('auth');


Route::get('/admin/tambahadmin', function () {
    return view('Admin.tambahadmin');
});

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index')->middleware('auth');

Route::post('/profile', [ProfileController::class, 'update'])
    ->name('profile.update')->middleware('auth');

Route::post('/pengerjaan/save', [ExamController::class, 'saveAnswer'])
    ->name('pengerjaan.save')
    ->middleware('auth');

Route::get('/pengerjaan/selesai/{score_id}', [ExamController::class, 'selesai']
)->name('pengerjaan.selesai')
 ->middleware('auth');

// Subtes Routes
// Route::resource('subtes', SubtesController::class);
