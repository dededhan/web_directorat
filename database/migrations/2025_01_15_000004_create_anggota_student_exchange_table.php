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
        Schema::create('anggota_student_exchange', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_student_exchange_id')->constrained('proposal_student_exchange')->onDelete('cascade');
            
            $table->string('nama_dosen');
            $table->string('nip')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->integer('urutan')->default(1);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('proposal_student_exchange_id');
            $table->index('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_student_exchange');
    }
};
