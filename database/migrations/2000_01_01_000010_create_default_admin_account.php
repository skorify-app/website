<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use function App\Http\Controllers\generateAccountID;
use function App\Http\Controllers\hashPassword;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('accounts')->insert([
            'account_id' => generateAccountID(),
            'full_name' => 'Admin Skorify',
            'email' => 'admin@default.email',
            'password' => hashPassword('P4$$word.'),
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
