<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->integerIncrements('score_id')->unsigned()->primary();
            $table->unsignedSmallInteger('subtest_id');
            $table->ulid('account_id');
            $table->smallInteger('score');
            $table->timestamp('recorded_at')->useCurrent();

            $table->foreign('subtest_id')
                ->references('subtest_id')->on('subtests')->onDelete('cascade');
            $table->foreign('account_id')
                ->references('account_id')->on('accounts')->onDelete('cascade');

            $table->index(['score_id', 'account_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
