<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function showLoginForm()
    {
        return view("page-login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email"=> "required|email",
            "password"=> "required",
            "role"=>"required"
        ]);
        // Samakan role input dengan huruf besar
        $role = strtoupper($request->role);

        //Ambil User berdasarkan email dan role
        $user = Account::where("email", $request->email)
        ->where("role", $role)
        ->first();

        if (!$user) {
            return back()->with('error', 'Email atau role salah');
        }

        if(!hash::check($request->password, $user->password)){
            return back()->with('error', 'Password salah');
        }

        // Simpan session (login berhasil)
        session([
            'user_id' => $user->account_id,
            'user_name' => $user->full_name,
            'user_role' => $user->role,
        ]);

        return redirect('/dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/page-login');
    }
}
