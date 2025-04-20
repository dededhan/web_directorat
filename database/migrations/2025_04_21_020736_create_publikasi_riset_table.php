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
        Schema::create('publikasi_riset', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('penulis');
            $table->text('deskripsi');
            $table->string('gambar_path')->nullable();
            $table->string('gambar_nama')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_nama')->nullable();
            $table->string('kategori')->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi_riset');
    }
};
