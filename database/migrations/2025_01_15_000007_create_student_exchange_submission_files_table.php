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
        Schema::create('student_exchange_submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_student_exchange_id')
                ->constrained('proposal_student_exchange')
                ->onDelete('cascade')
                ->name('se_submission_files_proposal_fk');
            $table->foreignId('student_exchange_sub_chapter_id')
                ->constrained('student_exchange_sub_chapter')
                ->onDelete('cascade')
                ->name('se_submission_files_subchapter_fk');
            
            $table->string('file_path')->nullable();
            $table->string('link_url')->nullable();
            $table->enum('tipe_file', ['pdf', 'link'])->default('pdf');
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('proposal_student_exchange_id', 'se_submission_files_proposal_idx');
            $table->index('student_exchange_sub_chapter_id', 'se_submission_files_subchapter_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exchange_submission_files');
    }
};
