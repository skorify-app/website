<?php

namespace Database\Seeders;

use App\Models\ParticipantAccount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        ParticipantAccount::factory(10)->create();
    }
}
