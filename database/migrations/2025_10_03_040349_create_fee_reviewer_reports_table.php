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
    Schema::create('fee_reviewer_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fee_reviewer_session_id')->constrained('fee_reviewer_sessions')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('judul_artikel');
        $table->string('nama_jurnal');
        $table->string('link_scimagojr')->nullable();
        $table->date('tanggal_review');
        $table->string('bukti_undangan_path');
        $table->string('bukti_hasil_review_path');
        $table->string('bukti_pengiriman_tepat_waktu_path')->nullable();
        $table->string('bukti_lain_path')->nullable();
        $table->string('surat_pernyataan_path');
        $table->string('status')->default('diajukan');
        $table->text('catatan_admin')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_reviewer_reports');
    }
};
