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
    Schema::create('presenting_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('presenting_session_id')->constrained('presenting_sessions')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        // --- Kolom sesuai form PresentingReport ---
        $table->string('nama_conference');
        $table->string('penyelenggaraan_ke')->nullable();
        $table->string('lembaga_penyelenggara');
        $table->string('link_website');
        $table->string('tempat_pelaksanaan'); // Kota
        $table->string('negara_pelaksanaan');
        $table->date('waktu_pelaksanaan_awal');
        $table->date('waktu_pelaksanaan_akhir');
        $table->string('judul_artikel');
        $table->string('sdg_terkait');
        $table->text('keywords_sdg')->nullable();
        $table->string('bukti_pendaftaran_path'); // Path file
        $table->string('bukti_loa_path'); // Path file LoA
        $table->text('rencana_anggaran')->nullable();
        $table->string('status')->default('diajukan'); // Status: diajukan, disetujui, ditolak

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presenting_reports');
    }
};
