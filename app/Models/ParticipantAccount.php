<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantAccount extends Model
{
    use HasFactory;
    use HasUlids;

    protected $connection = 'mysql';
    protected $table = 'accounts';
    protected $primaryKey = 'account_id';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $attributes = [
        'account_id' => null,
        'full_name' => null,
        'email' => null,
        'password' => null,
        'role' => 'PARTICIPANT',
    ];
}
