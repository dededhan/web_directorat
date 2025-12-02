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
        Schema::create('student_exchange_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_student_exchange_id')->constrained('sesi_student_exchange')->onDelete('cascade');
            
            $table->string('judul_modul');
            $table->text('deskripsi')->nullable();
            $table->date('periode_awal')->nullable();
            $table->date('periode_akhir')->nullable();
            $table->integer('urutan')->default(1);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('sesi_student_exchange_id');
            $table->index('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exchange_modul');
    }
};
