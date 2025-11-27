<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "email"=> "required|email",
            "password"=> "required|min:8|max:128"
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return Redirect::back()
            ->withErrors(['msg' => 'Email atau password Anda salah.'])
            ->withInput($request->only('email'));
    }

    public function login(Request $request): Redirector|RedirectResponse
    {
        $request->validate([
            "email"=> 'required|email|min:7|max:63',
            "password"=> 'required|min:3|max:63'
        ]);

        $user = Account::where("email", $request->input('email'))->first();

        if (!$user) {
            return back()->with('error', 'Email atau role salah');
        }

        if ($user->role === 'PARTICIPANT') {
            return back()->with('error', 'Maaf, hanya admin dan staf yang dapat masuk akun melalui situs ini');
        }

        if(!hash::check($request->input('password'), $user->password)){
            return back()->with('error', 'Password Anda salah, coba lagi');
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
}
