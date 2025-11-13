<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubtesController;

Route::get('/', function () {
    return view('page-login');
});

Route::post('/subtes', [SubtesController::class, 'store'])->name('subtes.store');
Route::get('/subtes', [SubtesController::class, 'index'])->name('subtes.index');




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