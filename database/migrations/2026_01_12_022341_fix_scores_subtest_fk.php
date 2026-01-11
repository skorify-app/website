<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            // Drop FK first
            $table->dropForeign('scores_subtest_id_foreign');
            
            // Ensure column is nullable
            $table->unsignedSmallInteger('subtest_id')->nullable()->change();
            
            // Re-add FK
            $table->foreign('subtest_id')
                ->references('subtest_id')->on('subtests')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
             // Drop FK
            $table->dropForeign('scores_subtest_id_foreign');
            
            // Revert column
            $table->unsignedSmallInteger('subtest_id')->nullable(false)->change();
            
             // Re-add FK
            $table->foreign('subtest_id')
                ->references('subtest_id')->on('subtests')->onDelete('cascade');
        });
    }
};
