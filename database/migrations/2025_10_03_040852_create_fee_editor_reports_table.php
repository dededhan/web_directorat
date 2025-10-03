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
    Schema::create('fee_editor_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('fee_editor_session_id')->constrained('fee_editor_sessions')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        // --- Kolom sesuai 7 poin ---
        $table->string('nama_jurnal'); // Poin 1
        $table->string('link_scimagojr')->nullable(); // Poin 2
        $table->string('peran'); // Poin 3: Editor-in-Chief, etc.
        $table->year('penugasan_awal'); // Poin 4 (awal)
        $table->year('penugasan_akhir'); // Poin 4 (akhir)
        $table->string('bukti_undangan_path'); // Poin 5 (path file)
        $table->string('link_laman_resmi'); // Poin 6
        $table->string('bukti_aktivitas_path')->nullable(); // Poin 7 (path file), boleh kosong
         $table->string('status')->default('diajukan');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_editor_reports');
    }
};
