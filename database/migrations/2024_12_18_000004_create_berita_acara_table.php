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
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->string('nomor_ba', 100)->nullable();
            $table->date('tanggal')->nullable();
            $table->string('tempat', 255)->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->json('peserta')->nullable()->comment('Array of participants');
            $table->text('agenda')->nullable();
            $table->text('hasil_pembahasan')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->unique(['form_id', 'validator_id'], 'unique_berita_acara');
            $table->index('nomor_ba', 'idx_nomor_ba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara');
    }
};
