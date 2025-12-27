<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Uid\Ulid;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('accounts')->insert([
            'account_id' => new Ulid(),
            'full_name' => 'Admin Skorify',
            'email' => 'admin@default.email',
            'password' => password_hash('P4$$word.', PASSWORD_ARGON2ID,  [
                'memory_cost' => 65536,
                'time_cost' => 3,
                'threads' => 4,
            ]),
            'role' => 'ADMIN'
        ]);
    }

    public function down(): void
    {
        DB::table('accounts')
            ->where('email', 'admin@default.email')
            ->delete();
    }
};
