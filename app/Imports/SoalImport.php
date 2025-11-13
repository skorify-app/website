<?php

namespace App\Imports;

use App\Models\Soal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements ToModel, WithHeadingRow
{
    protected $subtesId;

    public function __construct($subtesId)
    {
        $this->subtesId = $subtesId;
    }

    public function model(array $row)
    {
        return new Soal([
            'subtes_id' => $this->subtesId,
            'pertanyaan' => $row['teks_soal'], // disesuaikan dengan Excel kamu
            'opsi_a' => $row['opsi_a'],
            'opsi_b' => $row['opsi_b'],
            'opsi_c' => $row['opsi_c'],
            'opsi_d' => $row['opsi_d'],
            'jawaban_benar' => $row['opsi_jawaban_benar'], // sesuai header Excel
        ]);
    }
}
