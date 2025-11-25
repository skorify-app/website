<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Factory|View|RedirectResponse
    {
        if (Auth::check()) {
            $user = auth()->user();
            $role = strtolower($user->role ?? '');

            if ($role == 'staff' || $role == 'admin') {
                return view("dashboard/$role");
            } else {
                return view('page-error-400');
            }
        }

        return redirect()->route('/');
    }
}
