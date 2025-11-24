<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtest extends Model
{
    protected $primaryKey = 'subtest_id';
    
    protected $fillable = [
        'account_id', // Pastikan kolom relasi juga ada
        'subtest_name',
        'subtest_image_name',
        'excel_data_json',

    ];

    public $timestamps = false;
    protected $casts = [
        'excel_data_json' => 'array', // Laravel akan otomatis mengkonversi JSON ke array PHP saat diakses
    ];
    
    // Definisikan Relasi (Opsional, tapi disarankan)
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}