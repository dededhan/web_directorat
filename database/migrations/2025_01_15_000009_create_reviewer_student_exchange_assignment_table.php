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
        Schema::create('reviewer_student_exchange_assignment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->name('reviewer_se_assignment_reviewer_fk');
            $table->foreignId('proposal_student_exchange_id')
                ->constrained('proposal_student_exchange')
                ->onDelete('cascade')
                ->name('reviewer_se_assignment_proposal_fk');
            
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('reviewer_id', 'reviewer_se_assignment_reviewer_idx');
            $table->index('proposal_student_exchange_id', 'reviewer_se_assignment_proposal_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_student_exchange_assignment');
    }
};
