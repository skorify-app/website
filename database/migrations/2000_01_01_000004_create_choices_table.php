<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->unsignedInteger('question_id');
            $table->char('label', 1);
            $table->string('choice_value', 100);

            $table->foreign('question_id')
                ->references('question_id')->on('questions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
