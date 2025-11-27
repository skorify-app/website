<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    protected $table = 'accounts'; // nama tabel
    protected $primaryKey = 'account_id'; // primary key
    public $incrementing = false; // karena CHAR(26) bukan auto increment
    protected $keyType = 'string'; // tipe primary key

    public $timestamps = false; // ubah ke true kalau punya created_at/updated_at

    protected $fillable = [
        'account_id',
        'full_name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
}
