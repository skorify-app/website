<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('page-login'); // nanti kita buat file view-nya
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = Account::where('email', $request->input('email'))->first()
            ->where('role', $request->input('role'))
            ->first();

        if (!$user || !password_verify($request->input('password'), $user->password)) {
            return 'SALAH';
            //return back()->with('error', 'Email, password, atau role salah!');
        }

        Auth::login($user);

        return ($user->role === 'ADMIN')
            ? redirect('/Admin/dashboard')
            : redirect('/staff/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/page-login');
    }
}
