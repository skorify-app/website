<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use Symfony\Component\Uid\Ulid;

class StaffController extends Controller
{
    public function index(): Factory|View
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $staffs = Account::where('role', 'STAFF')->get();
        return view('staff', ['staffs' => $staffs]);
    }

    public function store(Request $request): JsonResponse
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || $user->role !== 'ADMIN') {
            abort(403);
        }

        $data = $request->validate([
            'full_name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:accounts,email',
            'password' => 'required|string|min:8|max:63',
        ]);

        $account = new Account();
        $account->account_id = generateAccountID();
        $account->full_name = $data['full_name'];
        $account->email = $data['email'];
        $account->password = hashpassword($data['password']);
        $account->role = 'STAFF';
        $account->save();

        return response()->json([
            'success' => true,
            'message' => 'Akun Staf berhasil ditambahkan',
            'staff' => ['id' => $account->account_id, 'name' => $account->full_name, 'email' => $account->email]
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $staff_acc_id = $request->input('account_id');
        $staff = Account::findOrFail($staff_acc_id);

        $data = $request->validate([
            'account_id' => 'required|string|size:26',
            'full_name' => 'required|string|max:191',
            'email' => ['required', 'email', 'max:191', 'unique:accounts,email,' . $staff->account_id . ',account_id'],
            'password' => 'nullable|string|min:8',
        ]);

        $staff->full_name = $data['full_name'];
        $staff->email = $data['email'];
        if (!empty($data['password'])) {
            $staff->password = hashPassword($data['password']);
        }
        $staff->save();

        return response()->json([
            'success' => true,
            'message' => 'Staff berhasil diperbarui.',
            'staff' => ['id' => $staff->account_id, 'name' => $staff->full_name, 'email' => $staff->email]
        ]);
    }

    public function destroy($staff_id): JsonResponse
    {
        // Only allow admins
        $user = Auth::user();
        if (!$user || strtoupper($user->role) !== 'ADMIN') {
            abort(403);
        }

        $staff = Account::findOrFail($staff_id);

        if ($staff->role !== 'STAFF') {
            abort(400);
        }

        $staff->delete();

        return response()->json(['success' => true, 'message' => 'Akun Staf berhasil dihapus']);
    }
}

function generateAccountID(): String {
    return new Ulid();
}

function hashPassword(string $password): string {
    $options = [
        'memory_cost' => 65536,
        'time_cost' => 3,
        'threads' => 4,
    ];
    return password_hash($password, PASSWORD_ARGON2ID, $options);
}

