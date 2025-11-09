<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_logs', function (Blueprint $table) {
            $table->integer('question_id');
            $table->string('old_text', 256);
            $table->char('old_answer', 1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_logs');
    }
};
