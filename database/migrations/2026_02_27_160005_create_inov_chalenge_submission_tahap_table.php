<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_submission_tahap', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            $table->unsignedBigInteger('inov_chalenge_tahap_id');
            $table->enum('status', ['belum_diisi', 'draft', 'diajukan'])->default('belum_diisi');
            $table->timestamp('submitted_at')->nullable();
            $table->enum('admin_status', ['menunggu', 'disetujui', 'perbaikan', 'selesai'])->default('menunggu');
            $table->decimal('nominal_evaluasi', 15, 2)->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('inov_chalenge_submission_id', 'st_submission_fk')
                ->references('id')->on('inov_chalenge_submissions')->cascadeOnDelete();
            $table->foreign('inov_chalenge_tahap_id', 'st_tahap_fk')
                ->references('id')->on('inov_chalenge_tahap')->cascadeOnDelete();
            $table->unique(['inov_chalenge_submission_id', 'inov_chalenge_tahap_id'], 'st_submission_tahap_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_submission_tahap');
    }
};
