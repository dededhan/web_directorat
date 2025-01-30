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
            $table->string('phone_responden')->nullable()->unique();
            $table->string('nama_dosen_pengusul');
            $table->string('phone_dosen')->nullable();
            $table->string('fakultas');
            $table->enum('category', ['academic', 'employer']);
            $table->enum('status', ['belum di-email', 'sudah di-email, belum di-follow up', 'sudah di-email, sudah di-follow up', 'selesai'])->default('belum di-email');
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
