<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->integerIncrements('question_id')->primary();
            $table->smallInteger('subtest_id');
            $table->string('question_text', 256);
            $table->char('answer_label', 1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
