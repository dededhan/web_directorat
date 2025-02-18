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
        Schema::create('dosen_internasionals', function (Blueprint $table) {
            $table->id();
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('nama');
            $table->string('negara');
            $table->string('universitas_asal');
            $table->string('status');
            $table->string('bidang_keahlian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_internasionals');
    }
};
