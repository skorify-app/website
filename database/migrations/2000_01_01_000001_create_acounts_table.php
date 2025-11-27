<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->ulid('account_id')->primary();
            $table->string('full_name', 60);
            $table->string('email', 60);
            $table->string('password', 128);
            $table->enum('role', ['ADMIN', 'STAFF', 'PARTICIPANT']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
