<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Account;

class StaffController extends Controller
{
    public function index()
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $staffs = Account::where('role', 'STAFF')->get();
        return view('Admin.staff', ['staffs' => $staffs]);
    }

    public function store(Request $request)
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $data = $request->validate([
            'full_name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:accounts,email',
            'password' => 'required|string|min:8',
        ]);

        $account = new Account();
        $account->account_id = Str::random(26);
        $account->full_name = $data['full_name'];
        $account->email = $data['email'];
        $account->password = Hash::make($data['password']);
        $account->role = 'STAFF';
        $account->save();

        return response()->json(['success' => true, 'message' => 'Staff berhasil ditambahkan.','staff' => ['id' => $account->account_id, 'name' => $account->full_name, 'email' => $account->email]]);
    }

    public function update(Request $request, $staff_id)
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $staff = Account::findOrFail($staff_id);

        $data = $request->validate([
            'full_name' => 'required|string|max:191',
            'email' => ['required', 'email', 'max:191', 'unique:accounts,email,' . $staff->account_id . ',account_id'],
            'password' => 'nullable|string|min:8',
        ]);

        $staff->full_name = $data['full_name'];
        $staff->email = $data['email'];
        if (!empty($data['password'])) {
            $staff->password = Hash::make($data['password']);
        }
        $staff->save();

        return response()->json(['success' => true, 'message' => 'Staff berhasil diperbarui.','staff' => ['id' => $staff->account_id, 'name' => $staff->full_name, 'email' => $staff->email]]);
    }

    public function destroy($staff_id)
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $staff = Account::findOrFail($staff_id);
        $staff->delete();

        return response()->json(['success' => true, 'message' => 'Staff berhasil dihapus.']);
    }
}
