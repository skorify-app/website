<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionImage extends Model
{
    use HasFactory;

    protected $table = 'question_images';

    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'image_name',
    ];

    // Relasi balik ke soal
    public function question()
    {
        return $this->belongsTo(Soal::class, 'question_id');
    }

    // Helper path gambar (opsional tapi rapi)
    public function getUrlAttribute()
    {
        return asset('storage/question_image/' . $this->image_name);
    }
}
