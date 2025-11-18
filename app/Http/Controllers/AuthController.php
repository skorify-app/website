<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user = Account::where('email', $request->email)
            ->where('role', $request->role)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email, password, atau role salah!');
        }

        Auth::login($user);

        return ($user->role === 'ADMIN')
            ? redirect('/Admin/dasboard')
            : redirect('/staff/index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/page-login');
    }
}
