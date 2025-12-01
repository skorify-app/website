<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(): Factory|View
    {
        return view('profile');
    }

    public function update(Request $request) {
        $data = $request->validate([
            'full_name' => 'nullable|string|max:60',
            'email' => 'nullable|email|min:6|max:60',
            'current_password' => 'nullable|string|min:8|max:100',
            'password' => 'nullable|string|min:8|max:100',
        ]);

        $user = Auth::user();

        if ($request->has('full_name')) {
            $user->full_name = $request->input('full_name');
            $user->save();

            return redirect()->back()->with('success', 'Nama lengkap Anda berhasil diperbarui');
        } else if ($request->has('email')) {
            $email = $request->input('email');
            $other_user = Account::where('email', $email)->first();
            if ($other_user && $other_user->account_id !== $user->account_id) {
                return redirect()->back()->with('error', 'Maaf, alamat email ini sudah digunakan akun lain');
            }

            $user->email = $email;
            $user->save();

            return redirect()->back()->with('success', 'Alamat email Anda berhasil diperbarui.');
        } else if ($request->has('password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi lama tidak cocok']);
            }

            $user->password = Hash::make($request->input('password'));
            $user->save();

            return redirect()->back()->with('success', 'Kata sandi Anda berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Maaf, terjadi kesalahan pada sistem');
    }
}
