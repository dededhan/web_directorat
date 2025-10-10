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
        Schema::create('anggota_penyusun', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_modul_id')->constrained('proposal_modul')->onDelete('cascade');
            $table->string('nama_dosen');
            $table->string('nip')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_penyusun');
    }
};
