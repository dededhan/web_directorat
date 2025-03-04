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
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->string('hari');
            $table->string('tanggal');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('keterangan_tanggal');
            $table->string('tempat');
            $table->string('surat_keputusan');
            $table->string('judul_inovasi');
            $table->string('jenis_inovasi');
            $table->decimal('nilai_tki', 5, 2);
            $table->text('opini_penilai');
            $table->date('tanggal_penutupan');
            $table->string('ttd_penanggungjawab')->nullable();
            $table->string('nama_penanggungjawab');
            $table->string('ttd_ketua_tim')->nullable();
            $table->string('nama_ketua_tim');
            $table->string('ttd_anggota1')->nullable();
            $table->string('nama_anggota1');
            $table->string('ttd_anggota2')->nullable();
            $table->string('nama_anggota2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
