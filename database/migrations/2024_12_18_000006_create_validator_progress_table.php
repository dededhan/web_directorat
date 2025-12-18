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
        Schema::create('validator_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->boolean('agreement_completed')->default(false);
            $table->boolean('assessment_completed')->default(false);
            $table->boolean('berita_acara_completed')->default(false);
            $table->boolean('record_completed')->default(false);
            $table->boolean('all_completed')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['assigned', 'in_progress', 'in_review', 'completed'])->default('assigned');
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('innovator_forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->unique(['form_id', 'validator_id'], 'unique_progress');
            $table->index('status', 'idx_progress_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_progress');
    }
};
