<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hackaton_progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')
                ->constrained('hackaton_submissions')
                ->cascadeOnDelete();
            $table->foreignId('hackaton_tahap_id')
                ->nullable()
                ->constrained('hackaton_tahap')
                ->nullOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->unsignedTinyInteger('capaian_persen');
            $table->timestamps();

            $table->index(['hackaton_submission_id', 'tanggal'], 'hackaton_progress_sub_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hackaton_progress_logs');
    }
};