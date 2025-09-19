<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi'); // Nama Sesi / Penelitian
            $table->text('deskripsi'); // Deskripsi Kegiatan
            $table->decimal('dana_maksimal', 15, 2); // Dana Maksimal
            $table->date('periode_awal'); // Periode (tanggal awal)
            $table->date('periode_akhir'); // Periode (tanggal akhir)
            $table->integer('min_anggota')->default(1); // Anggota (minimal)
            $table->integer('max_anggota')->default(4); // Anggota (maksimal)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_sessions');
    }
};