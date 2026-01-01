<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $primaryKey = 'question_id';

    public $timestamps = false;

    protected $fillable = [
        'subtest_id',
        'question_text',
    ];

    // Relasi ke subtes
    public function subtest()
    {
        return $this->belongsTo(Subtest::class, 'subtest_id');
    }

    // Relasi ke pilihan jawaban
    public function choices()
    {
        return $this->hasMany(Choice::class, 'question_id')
                    ->orderBy('label');
    }

    // Relasi ke gambar soal
    public function image()
    {
        return $this->hasOne(QuestionImage::class, 'question_id');
    }
}
