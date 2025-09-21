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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel comdev_submissions
            // onDelete('cascade') berarti jika proposal dihapus, semua logbooknya juga ikut terhapus.
            $table->foreignId('comdev_submission_id')->constrained()->onDelete('cascade');
            
            $table->date('activity_date'); // Tanggal Kegiatan
            $table->text('notes'); // Catatan
            $table->unsignedTinyInteger('progress_percentage'); // Persen Capaian (0-100)
            $table->string('attachment_path')->nullable(); // Path file lampiran (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};