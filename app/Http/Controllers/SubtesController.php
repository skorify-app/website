<?php

namespace App\Http\Controllers;

use App\Models\Subtes;
use App\Imports\SoalImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubtesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_subtes' => 'required|string|max:255',
                'file_soal' => 'required|file|mimes:xlsx,xls,csv',
            ]);

            $subtes = Subtes::create([
                'nama_subtes' => $request->nama_subtes,
            ]);

            Excel::import(new SoalImport($subtes->id), $request->file('file_soal'));

            return response()->json(['message' => 'Subtes and soal imported successfully', 'subtes' => $subtes], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create subtes or import soal', 'message' => $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        }
    }

    public function index()
    {
        $subtes = Subtes::withCount('soal')->get();
        return response()->json($subtes);
    }
}
