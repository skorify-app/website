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
