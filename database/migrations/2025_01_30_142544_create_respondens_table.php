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
        Schema::create('respondens', function (Blueprint $table) {
            $table->id();
            $table->string('title', 4);
            $table->string('fullname');
            $table->string('jabatan');
            $table->string('instansi');
            $table->string('email')->unique();
            $table->string('phone_responden')->nullable();
            $table->string('nama_dosen_pengusul');
            $table->string('phone_dosen')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('category')->nullable();
            $table->enum('status', ['belum', 'done', 'dones','clear'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondens');
    }
};
