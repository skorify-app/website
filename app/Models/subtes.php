<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtes extends Model
{
    use HasFactory;

    protected $table = 'subtests';
    protected $fillable = ['subtest_name'];

    public function soal()
    {
        return $this->hasMany(Soal::class, 'subtes_id');
    }
}
