<?php

use App\Http\Controllers\StaffController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubtestController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;



# Main page
# Main page
Route::get('/', [IndexController::class, 'index'])->name('index');

# Log in routes
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

# Log out route
Route::get('/logout', [LogoutController::class, 'destroy'])->name('logout');

# Protected Routes Group
Route::middleware(['auth'])->group(function () {
    # Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    # Chart Data API
    Route::get('/admin/chart-data/{year}', [DashboardController::class, 'getChartData'])->name('admin.chartData');
    Route::get('/admin/recap-stats', [DashboardController::class, 'getRecapStats'])->name('admin.recapStats');

    # Subtest
    Route::get('/subtest', [SubtestController::class, 'index'])->name('subtest.index');
    Route::post('/subtest', [SubtestController::class, 'store'])->name('subtest.store');
    Route::delete('/subtest/{subtest_id}', [SubtestController::class, 'delete'])->name('subtest.delete');
    Route::post('/subtest/update', [SubtestController::class, 'update'])->name('subtest.update');

    # Manage staff accounts
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::post('/staff/update', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff_id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    # Pengerjaan Soal (Staff) - Secured
    Route::get('/staff/pengerjaan', function () {
        return view('Staff.pengerjaan');
    });

    # Pengerjaan Soal (Admin)
    Route::get('/admin/pengerjaan/{subtest_id}', [ExamController::class, 'index'])->name('pengerjaan');

    # Tambah Admin Page - Secured
    Route::get('/admin/tambahadmin', function () {
        return view('Admin.tambahadmin');
    });

    # Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    # Exam Execution & Saving
    Route::post('/pengerjaan/save', [ExamController::class, 'saveAnswer'])->name('pengerjaan.save');
    Route::get('/pengerjaan/selesai/{score_id}', [ExamController::class, 'selesai'])->name('pengerjaan.selesai');

    # Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
});
