<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubtesController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function() {
    return "Welcome Admin!";
})->middleware('auth');

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


Route::get('/', function () {
    return view('page-login');
});



// Staff Routes
Route::get('/index', function () {
    return view('staff.index');
});

Route::get('/subtes', function () {
    return view('staff.subtes');
});



// Admin Routes
Route::get('/admin/dasboard', function () {
    return view('Admin.dasboard');
});

Route::get('/admin/tambahadmin', function () {
    return view('Admin.tambahadmin');
});

