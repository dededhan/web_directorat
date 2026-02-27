<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_challenge_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('inov_challenge_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // dosen leader
            $table->string('title', 255);
            
            // Phase 1 fields
            $table->json('phase_1_data')->nullable();
            $table->enum('phase_1_status', ['draft', 'submitted', 'under_review', 'reviewed', 'approved', 'rejected'])->default('draft');
            $table->timestamp('phase_1_submitted_at')->nullable();
            
            // Phase 2 fields
            $table->json('phase_2_data')->nullable();
            $table->enum('phase_2_status', ['not_started', 'in_progress', 'uploaded', 'under_review', 'reviewed', 'approved', 'rejected'])->default('not_started');
            $table->timestamp('phase_2_submitted_at')->nullable();
            
            // Phase 3 fields
            $table->json('phase_3_data')->nullable();
            $table->enum('phase_3_status', ['not_started', 'in_progress', 'submitted', 'under_review', 'reviewed', 'approved', 'rejected'])->default('not_started');
            $table->timestamp('phase_3_submitted_at')->nullable();
            
            // Final status
            $table->enum('final_status', ['draft', 'in_progress', 'completed', 'rejected'])->default('draft');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_challenge_submissions');
    }
};
