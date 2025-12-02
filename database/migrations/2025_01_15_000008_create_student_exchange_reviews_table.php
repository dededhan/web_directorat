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
        Schema::create('student_exchange_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_student_exchange_id')
                ->constrained('proposal_student_exchange')
                ->onDelete('cascade')
                ->name('se_reviews_proposal_fk');
            $table->foreignId('student_exchange_sub_chapter_id')
                ->constrained('student_exchange_sub_chapter')
                ->onDelete('cascade')
                ->name('se_reviews_subchapter_fk');
            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->name('se_reviews_reviewer_fk');
            
            $table->text('komentar')->nullable();
            $table->integer('nilai')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('proposal_student_exchange_id', 'se_reviews_proposal_idx');
            $table->index('student_exchange_sub_chapter_id', 'se_reviews_subchapter_idx');
            $table->index('reviewer_id', 'se_reviews_reviewer_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exchange_reviews');
    }
};
