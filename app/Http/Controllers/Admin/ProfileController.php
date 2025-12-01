<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function updateName(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:191',
        ]);

        $user = Auth::user();
        $user->full_name = $request->input('full_name');
        $user->save();

        return redirect()->back()->with('success', 'Nama berhasil diperbarui.');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191|unique:accounts,email,' . Auth::id() . ',account_id',
        ]);

        $user = Auth::user();
        $user->email = $request->input('email');
        $user->save();

        return redirect()->back()->with('success', 'Email berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama tidak cocok.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
