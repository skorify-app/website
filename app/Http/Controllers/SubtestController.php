<?php

namespace App\Http\Controllers;

use App\Models\Subtest;
use App\Imports\SubtestImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class SubtestController extends Controller
{
    // ... metode index, edit, show ...

    /**
     * Menyimpan data Subtest baru (Create).
     */
    public function store(Request $request)
    {
        $request->validate([
            'subtest_name' => 'required|string|max:255',
            'subtest_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Batas 2MB default
            'excel_file' => 'required|file|mimes:xlsx,xls,csv', // File Excel/CSV
        ]);

        // Inisialisasi variabel path
        $imagePath = null;
        $tempExcelPath = null;

        // Mulai Database Transaction untuk Rollback
        DB::beginTransaction();

        try {
            // 1. Upload Gambar (Jika ada)
            if ($request->hasFile('subtest_image')) {
                // Simpan gambar di folder public/images
                $imagePath = $request->file('subtest_image')->store('public/images');
                $imageName = basename($imagePath);
            } else {
                $imageName = null;
            }

            // 2. Upload dan Parsing File Excel/CSV
            $file = $request->file('excel_file');
            
            // Simpan sementara file Excel untuk parsing
            $tempExcelPath = $file->storeAs('temp/excels', time() . '_' . $file->getClientOriginalName());

            // Lakukan parsing, dapatkan collection data soal
            $collection = Excel::toCollection(new SubtestImport, storage_path('app/' . $tempExcelPath));
            
            // Ambil data (asumsi data ada di sheet pertama)
            $questionsData = $collection->first(); 
            
            // Konversi Collection data soal ke JSON string
            $excelJsonData = $questionsData->toJson();
            
            // 3. Simpan ke Database
            $subtes = Subtest::create([
                // Contoh: Ambil ID user yang sedang login
                'account_id' => auth()->id() ?? 1, 
                'subtest_name' => $request->subtest_name,
                'subtest_image_name' => $imageName,
                'excel_data_json' => $excelJsonData, // Data JSON siap disimpan
            ]);

            // 4. Bersihkan file Excel sementara
            Storage::delete($tempExcelPath);

            // Jika semua langkah berhasil, COMMIT
            DB::commit();

            return redirect()->route('subtests.index')->with('success', 'Subtest berhasil ditambahkan!');

        } catch (Exception $e) {
            // Jika terjadi kesalahan (parsing, database, dll), ROLLBACK
            DB::rollBack();

            // Hapus file yang sudah terlanjur di-upload jika terjadi error
            if ($imagePath) {
                Storage::delete($imagePath);
            }
            if ($tempExcelPath) {
                 Storage::delete($tempExcelPath);
            }

            return redirect()->back()->with('error', 'Gagal menambahkan Subtest: ' . $e->getMessage())->withInput();
        }
    }
    
    // ... metode update dan destroy (Juga disarankan menggunakan Transaction)
    
    /**
     * Menampilkan data Subtest (Read).
     */
    public function index()
    {
        $subtests = Subtest::orderBy('subtest_id')->get();
        return view('staff.subtes', compact('subtests'));
    }
}