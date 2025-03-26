<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->date('tanggal_publikasi');
            $table->string('judul_dokumen');
            $table->text('deskripsi')->nullable();
            $table->string('nama_file');
            $table->string('nama_file_hash');
            $table->string('path');
            $table->integer('ukuran');
            $table->string('ekstensi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumens');
    }
};