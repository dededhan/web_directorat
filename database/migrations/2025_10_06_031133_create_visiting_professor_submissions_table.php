<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visiting_professor_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke user (akun fakultas)
            $table->string('nama_pengunggah');
            $table->string('proposal_path'); // Bisa untuk path file atau link
            $table->enum('status', ['diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->text('catatan_admin')->nullable(); // Catatan dari admin jika ditolak/perlu revisi
            $table->string('bukti_keuangan_path')->nullable(); // Diisi setelah disetujui
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visiting_professor_submissions');
    }
};