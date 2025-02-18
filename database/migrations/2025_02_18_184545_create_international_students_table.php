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
        Schema::create('international_students', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->string('nim')->unique();
            $table->string('negara');
            $table->enum('kategori', ['inbound', 'outbound']);
            $table->enum('status', ['fulltime', 'parttime', 'other']);
            $table->string('fakultas');
            $table->string('program_studi');
            $table->date('periode_mulai');
            $table->date('periode_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_students');
    }
};
