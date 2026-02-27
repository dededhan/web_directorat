<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_tahap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inov_chalenge_session_id')
                ->constrained('inov_chalenge_sessions')
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('tahap_ke'); // 1, 2, or 3
            $table->string('nama_tahap')->default('');
            $table->text('deskripsi')->nullable();
            $table->dateTime('periode_awal')->nullable();
            $table->dateTime('periode_akhir')->nullable();
            $table->boolean('has_anggota')->default(false);  // true only for tahap 1
            $table->boolean('has_fakultas')->default(false); // true only for tahap 1
            $table->timestamps();

            $table->unique(['inov_chalenge_session_id', 'tahap_ke']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_tahap');
    }
};
