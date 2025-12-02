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
        Schema::create('proposal_student_exchange', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_student_exchange_id')->constrained('sesi_student_exchange')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Basic Information
            $table->string('judul_kegiatan');
            $table->text('ringkasan_kegiatan', 300)->nullable();
            $table->json('sdgs_fokus')->nullable();
            $table->json('sdgs_pendukung')->nullable();
            $table->enum('jenis_kegiatan', ['inbound', 'outbound']);
            
            // Participant Information
            $table->integer('jumlah_peserta');
            $table->integer('sks');
            $table->string('nama_mahasiswa_path')->nullable();
            $table->string('mata_kuliah_path')->nullable();
            $table->string('rab_path')->nullable();
            
            // Schedule
            $table->date('tanggal_online')->nullable();
            $table->date('tanggal_onsite')->nullable();
            
            // Status and Review
            $table->enum('status', [
                'draft',
                'diajukan',
                'menunggu_verifikasi',
                'diterima',
                'ditolak',
                'menunggu_direview',
                'sedang_direview',
                'lolos',
                'tidak_lolos'
            ])->default('draft');
            
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('komentar_admin')->nullable();
            $table->text('komentar_reviewer')->nullable();
            $table->text('alasan_penolakan')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('sesi_student_exchange_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('reviewer_id');
            $table->index('jenis_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_student_exchange');
    }
};
