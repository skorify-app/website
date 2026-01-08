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
        // Manual validation to show custom error message
        if (!$request->email || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return Redirect::back()
                ->with('error', 'Email atau kata sandi anda salah')
                ->withInput($request->only('email'));
        }

        if (!$request->password || strlen($request->password) < 3) {
            return Redirect::back()
                ->with('error', 'Email atau kata sandi anda salah')
                ->withInput($request->only('email'));
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return Redirect::back()
            ->with('error', 'Email atau kata sandi anda salah')
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
            return back()->with('error', 'Email atau kata sandi anda salah');
        }

        if ($user->role === 'PARTICIPANT') {
            return back()->with('error', 'Maaf, hanya admin dan staf yang dapat masuk akun melalui situs ini');
        }

        if(!hash::check($request->input('password'), $user->password)){
            return back()->with('error', 'Email atau kata sandi anda salah');
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
}
