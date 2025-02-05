<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sustainabilities', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan');
            $table->date('tanggal_kegiatan');
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('link_kegiatan')->nullable();
            $table->text('deskripsi_kegiatan');
            $table->timestamps();
        });
    }
 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sustainabilities');
    }
};
