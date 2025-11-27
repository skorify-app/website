<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recorded_answers', function (Blueprint $table) {
            $table->unsignedInteger('score_id');
            $table->unsignedInteger('question_id');

            $table->foreign('score_id')
                ->references('score_id')->on('scores')->onDelete('cascade');
            $table->foreign('question_id')
                ->references('question_id')->on('questions')->onDelete('cascade');
            $table->char('answer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recorded_answers');
    }
};
