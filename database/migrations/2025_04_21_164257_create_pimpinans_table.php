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
        Schema::create('pimpinans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jabatan', [
                'Direktur Inovasi Sistem Informasi dan Pemeringkatan',
                'Kepala Subdirektorat Inovasi dan Hilirisai',
                'Kepala Subdirektorat Sistem Informasi dan Pemeringkatan'
            ]);
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinans');
    }
};
