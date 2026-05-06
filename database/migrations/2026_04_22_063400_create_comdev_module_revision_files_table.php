<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comdev_module_revision_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comdev_submission_id')->constrained('comdev_submissions')->onDelete('cascade');
            $table->foreignId('comdev_module_id')->constrained('comdev_modules')->onDelete('cascade');
            $table->foreignId('comdev_sub_chapter_id')->nullable()->constrained('comdev_sub_chapters')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type')->default('file'); // 'file' or 'link'
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('url')->nullable();
            $table->text('catatan_dosen')->nullable();
            $table->unsignedInteger('revision_round')->default(1);
            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comdev_module_revision_files');
    }
};
