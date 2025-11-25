<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page-login');
});

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
