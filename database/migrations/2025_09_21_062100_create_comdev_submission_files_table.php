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
        Schema::create('comdev_submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comdev_submission_id')->constrained('comdev_submissions')->onDelete('cascade');
            $table->foreignId('comdev_sub_chapter_id')->constrained('comdev_sub_chapters')->onDelete('cascade');
            $table->foreignId('user_id')->comment('ID Dosen yang mengunggah')->constrained('users')->onDelete('cascade');
            $table->string('file_path');
            $table->string('original_filename');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comdev_submission_files');
    }
};