<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            $table->unsignedBigInteger('inov_chalenge_tahap_id')->nullable();
            $table->string('tipe', 50); // 'submission' or 'tahap'
            $table->string('status_dari', 100)->nullable();
            $table->string('status_ke', 100);
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('causer_id')->nullable(); // user who triggered
            $table->string('causer_role', 50)->nullable(); // 'dosen', 'admin', 'system'
            $table->timestamps();

            $table->foreign('inov_chalenge_submission_id')
                ->references('id')->on('inov_chalenge_submissions')
                ->cascadeOnDelete();

            $table->foreign('inov_chalenge_tahap_id')
                ->references('id')->on('inov_chalenge_tahap')
                ->nullOnDelete();

            $table->foreign('causer_id')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->index(['inov_chalenge_submission_id', 'created_at'], 'ic_status_logs_submission_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_status_logs');
    }
};
