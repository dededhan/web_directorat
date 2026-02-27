<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_challenge_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('inov_challenge_submissions')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->enum('phase', ['phase_1', 'phase_2', 'phase_3']);
            $table->decimal('score', 5, 2)->nullable(); // max 999.99
            $table->text('feedback')->nullable();
            $table->json('review_criteria')->nullable(); // detail scoring per kriteria
            $table->enum('status', ['assigned', 'in_progress', 'completed'])->default('assigned');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_challenge_reviews');
    }
};
