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
        // Perintah ini akan membuat tabel 'comdev_submission_reviewer'
        Schema::create('comdev_submission_reviewer', function (Blueprint $table) {
            $table->id();

            // Kolom untuk menghubungkan ke proposal (submission)
            $table->foreignId('comdev_submission_id')
                  ->constrained('comdev_submissions') // Pastikan nama tabel submission Anda 'comdev_submissions'
                  ->onDelete('cascade'); // Jika proposal dihapus, penugasan ini juga ikut terhapus

            // Kolom untuk menghubungkan ke user (reviewer)
            $table->foreignId('reviewer_id')
                  ->constrained('users') // Menghubungkan ke tabel 'users'
                  ->onDelete('cascade'); // Jika user reviewer dihapus, penugasan ini juga ikut terhapus

            $table->timestamps();

            // ===================================================================
            // PERUBAHAN UTAMA DI SINI
            // Kita memberikan nama custom 'submission_reviewer_unique' yang lebih pendek.
            // ===================================================================
            $table->unique(['comdev_submission_id', 'reviewer_id'], 'submission_reviewer_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comdev_submission_reviewer');
    }
};

