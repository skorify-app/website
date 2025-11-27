<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): Factory|View|RedirectResponse
    {
        $user = auth()->user();
        $role = strtolower($user->role ?? '');

        if ($role == 'staff' || $role == 'admin') {
            $total_acc = DB::table('AccountSummary')->get();
            return view("dashboard/$role", ['total_acc' => $total_acc]);
        } else {
            return view('page-error-400');
        }
    }
}
