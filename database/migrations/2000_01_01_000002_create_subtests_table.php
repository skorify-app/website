<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subtests', function (Blueprint $table) {
            $table->smallIncrements('subtest_id')->unsigned()->primary();
            $table->string('subtest_name', 20)->unique();
            $table->string('subtest_image_name', 20)->nullable()->unique();
            $table->unsignedInteger('duration_seconds');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subtests');
    }
};
