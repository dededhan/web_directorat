<?php
// File: YYYY_MM_DD_XXXXXX_create_proposal_members_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_members', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel submission utama
            $table->foreignId('comdev_submission_id')->constrained('comdev_submissions')->onDelete('cascade');
            
            $table->string('peran'); // Isinya 'Ketua' atau 'Anggota'
            $table->string('nama_lengkap');
            $table->string('nik_nim_nip');
            $table->string('alamat_jalan');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kode_pos')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_members');
    }
};