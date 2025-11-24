<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Penting untuk membaca nama kolom/header

// WithHeadingRow memastikan baris pertama dianggap sebagai nama kolom
class SubtestImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // $rows berisi data dari file Excel/CSV dalam bentuk collection
        
        // Kita tidak akan menyimpan data per baris,
        // tapi mengembalikan seluruh collection untuk diproses di Controller.
        
        // Catatan: Pastikan nama header di file Excel/CSV Anda sama persis 
        // dengan key yang diharapkan: teks_soal, opsi_a, dst.
        
        return $rows;
    }
}