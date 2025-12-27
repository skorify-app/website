<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(<<<SQL
CREATE OR REPLACE VIEW AccountSummary AS
SELECT
    role,
    COUNT(*) AS total
FROM accounts
GROUP BY role
SQL
        );
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS AccountSummary');
    }
};
