<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employer_meeting_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_pengunggah');
            $table->string('proposal_path');
            $table->enum('status', ['diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->text('catatan_admin')->nullable();
            $table->string('bukti_keuangan_path')->nullable();
            $table->text('nama_calon_responden')->nullable(); // Kolom tambahan khusus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_meeting_submissions');
    }
};