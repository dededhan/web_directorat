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
        Schema::create('proposal_modul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_hibah_modul_id')->constrained('sesi_hibah_modul')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('judul_modul')->nullable();
            $table->text('ringkasan_modul')->nullable();
            $table->json('kata_kunci')->nullable();
            $table->json('sdgs')->nullable();
            $table->string('file_proposal')->nullable();
            
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
            $table->decimal('nominal_hibah', 15, 2)->nullable();
            $table->text('komentar_admin')->nullable();
            $table->text('komentar_reviewer')->nullable();
            $table->text('alasan_penolakan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_modul');
    }
};
