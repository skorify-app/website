<?php

namespace App\Http\Controllers;

use App\Models\Subtest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubtestController extends Controller
{
    public function index(): Factory|View
    {
        $role = auth()->user()->role ?? '';
        $subtests = Subtest::all()->toArray();
        return view('subtest.index', ['role' => $role, 'subtests' => $subtests]);
    }

    public function store(): JsonResponse
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file',
        ]);

        $name = $data['name'];

        $subtest_exist = Subtest::where('subtest_name', $name)->exists();
        if ($subtest_exist) {
            return response()->json([
                'error' => 'Subtes ini sudah terdaftar'
            ], 400);
        }

        Subtest::create([
            'subtest_name' => $name,
        ]);

        return response()->json(null, 204);
    }

    public function delete(String $subtest_id): JsonResponse
    {
        $subtest = Subtest::where('subtest_id', $subtest_id)->first();
        if (!$subtest->exists()) return response()->json(null, 404);

        Subtest::destroy($subtest_id);
        return response()->json(null, 204);
    }
}
