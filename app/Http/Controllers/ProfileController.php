<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Pastikan semua aksi profile hanya untuk user yang sudah login
        $this->middleware('auth');
    }

    /**
     * Halaman profil (staff/admin)
     * resources/views/Staff/profile.blade.php
     */
    public function index(Request $request)
    {
        return view('Staff.profile', [
            'user' => $request->user(), // supaya di Blade mudah ambil nama/email/role
        ]);
    }

    /**
     * Ubah nama
     * Expect: name
     * Return: JSON { ok, message, user:{name} }
     */
    public function updateName(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->name = $validated['name'];
        $user->save();

        return response()->json([
            'ok'      => true,
            'message' => 'Nama berhasil diperbarui.',
            'user'    => ['name' => $user->name],
        ]);
    }

    /**
     * Ubah email
     * Expect: email
     * Return: JSON { ok, message, user:{email} }
     *
     * Catatan:
     * - Jika app kamu pakai verifikasi email, pertimbangkan set $user->email_verified_at = null
     *   lalu kirim ulang email verifikasi.
     */
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
        ]);

        $user = $request->user();

        // Kalau email tidak berubah, langsung sukses agar UX enak
        if ($validated['email'] === $user->email) {
            return response()->json([
                'ok'      => true,
                'message' => 'Email tidak berubah.',
                'user'    => ['email' => $user->email],
            ]);
        }

        $user->email = $validated['email'];
        // Jika perlu verifikasi ulang:
        // $user->email_verified_at = null;
        $user->save();

        return response()->json([
            'ok'      => true,
            'message' => 'Email berhasil diperbarui.',
            'user'    => ['email' => $user->email],
        ]);
    }

    /**
     * Ubah password
     * Expect:
     *  - current_password
     *  - new_password   (menyesuaikan UI kamu yang cuma 2 field)
     *
     * Return: JSON { ok, message }
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'string', 'min:8'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password baru minimal 8 karakter.',
        ]);

        $user = $request->user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'ok'      => false,
                'message' => 'Password lama salah.',
            ], 422);
        }

        // Cegah password baru sama dengan yang lama (opsional tapi disarankan)
        if (Hash::check($validated['new_password'], $user->password)) {
            return response()->json([
                'ok'      => false,
                'message' => 'Password baru tidak boleh sama dengan password lama.',
            ], 422);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json([
            'ok'      => true,
            'message' => 'Password berhasil diperbarui.',
        ]);
    }
}
