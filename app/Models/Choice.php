<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $table = 'choices';

    protected $primaryKey = 'choice_id'; // sesuaikan kalau ada

    protected $fillable = [
        'question_id',
        'label',         // A, B, C, D
        'choice_value',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
