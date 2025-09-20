<?php
// File: YYYY_MM_DD_XXXXXX_create_comdev_submissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comdev_submissions', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel sesi proposal
            $table->foreignId('comdev_proposal_id')->constrained('proposal_sessions')->onDelete('cascade');
            // Foreign key ke user Dosen yang menjadi Ketua Tim
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom dari form detail pengajuan (awalnya bisa null)
            $table->string('judul')->nullable();
            $table->year('tahun_usulan')->nullable();
            $table->string('tempat_pelaksanaan')->nullable();
            $table->text('abstrak')->nullable();
            $table->decimal('nominal_usulan', 15, 2)->nullable();
            $table->json('kata_kunci')->nullable();
            $table->json('sdgs')->nullable();
            $table->json('mitra_nasional')->nullable();
            $table->json('mitra_internasional')->nullable();
            
            // Kolom untuk alur kerja (workflow)
            $table->string('status')->default('draft'); // Status: draft, diajukan, sedang_direview, dll.
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comdev_submissions');
    }
};