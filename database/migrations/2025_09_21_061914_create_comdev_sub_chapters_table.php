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
        Schema::create('comdev_sub_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comdev_module_id')->constrained('comdev_modules')->onDelete('cascade');
            $table->string('nama_sub_bab');
            $table->text('deskripsi_instruksi')->nullable(); // Instruksi untuk dosen
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->dateTime('periode_awal')->nullable()->comment('Waktu mulai unggah untuk sub-bab ini');
            $table->dateTime('periode_akhir')->nullable()->comment('Batas akhir unggah untuk sub-bab ini');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comdev_sub_chapters');
    }
};
