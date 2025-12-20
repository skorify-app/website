<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtest extends Model
{
    protected $table = 'subtests';
    protected $primaryKey = 'subtest_id';
    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'subtest_id',
        'subtest_name',
        'subtest_image_name',
        'duration_minutes',
    ];
}
