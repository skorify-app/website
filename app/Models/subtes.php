<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtes extends Model
{
    use HasFactory;

    protected $table = 'subtes';
    protected $fillable = ['nama_subtes'];

    public function soal()
    {
        return $this->hasMany(Soal::class, 'subtes_id');
    }
}
