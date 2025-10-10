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
        Schema::create('modul_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_hibah_modul_id')->constrained('sesi_hibah_modul')->onDelete('cascade');
            $table->string('judul_modul');
            $table->text('deskripsi')->nullable();
            $table->date('periode_awal')->nullable();
            $table->date('periode_akhir')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_akhir');
    }
};
