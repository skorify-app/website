<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_images', function (Blueprint $table) {
            $table->unsignedInteger('question_id');
            $table->string('image_name', 20);

            $table->foreign('question_id')
                ->references('question_id')
                ->on('questions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_logs');
    }
};
