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
    Schema::create('presenting_submissions', function (Blueprint $table) {
        $table->id();
        // Relasi one-to-one ke tabel report
        $table->foreignId('presenting_report_id')->unique()->constrained('presenting_reports')->onDelete('cascade');

        // --- Kolom sesuai form PresentingSubmission ---
        $table->string('bukti_perjalanan_path')->nullable();
        $table->string('sertifikat_presenter_path')->nullable();
        $table->string('ppt_path')->nullable();
        $table->string('bukti_partner_riset_path')->nullable();
        $table->string('sp_setneg_path')->nullable();
        $table->string('responden_internasional_qs_path')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presenting_submissions');
    }
};
