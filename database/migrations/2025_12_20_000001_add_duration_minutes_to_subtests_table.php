<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // only add column if it doesn't already exist (prevents duplicates on existing DBs)
        if (!Schema::hasColumn('subtests', 'duration_seconds')) {
            Schema::table('subtests', function (Blueprint $table) {
                $table->unsignedInteger('duration_seconds')->default(30 * 60)->after('subtest_image_name');
            });
        }
    }

    public function down(): void
    {
        // only drop column if it exists
        if (Schema::hasColumn('subtests', 'duration_seconds')) {
            Schema::table('subtests', function (Blueprint $table) {
                $table->dropColumn('duration_seconds');
            });
        }
    }
};
