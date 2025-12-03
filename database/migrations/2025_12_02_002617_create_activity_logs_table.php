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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // siapa yg melakukan
            $table->string('action'); // login, create, update, delete, print
            $table->string('module')->nullable(); // misal: 'idcard', 'user', dll
            $table->unsignedBigInteger('target_id')->nullable(); // id data yg diubah
            $table->text('description')->nullable(); // keterangan bebas
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
