<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
{
    if (!session('logged_in')) {
        return redirect('/login')->with('error', 'Silakan login dulu!');
    }

    return $next($request);
}
}
