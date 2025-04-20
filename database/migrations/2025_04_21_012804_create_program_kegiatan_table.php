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
        Schema::create('program_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->enum('kategori', ['penelitian', 'pengabdian_masyarakat', 'pendidikan', 'kolaborasi']);
            $table->text('deskripsi');
            $table->string('nama_gambar');
            $table->string('nama_gambar_hash');
            $table->string('path_gambar');
            $table->integer('ukuran_gambar');
            $table->string('ekstensi_gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_kegiatan');
    }
};
