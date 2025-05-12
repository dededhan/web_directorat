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
        Schema::create('international_faculty_staff', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('fakultas');
            $table->string('universitas_asal');
            $table->string('bidang_keahlian');
            $table->string('qs_wur')->nullable();
            $table->string('qs_subject')->nullable();
            $table->string('scopus')->nullable();
            $table->string('foto_path')->nullable();
            $table->year('tahun');
            $table->enum('category', ['fulltime', 'adjunct']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_faculty_staff');
    }
};