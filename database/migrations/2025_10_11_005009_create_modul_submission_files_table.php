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
        Schema::create('modul_submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_modul_id')->constrained('proposal_modul')->onDelete('cascade');
            $table->foreignId('modul_sub_chapter_id')->constrained('modul_sub_chapter')->onDelete('cascade');
            $table->string('file_path')->nullable();
            $table->string('link_url')->nullable();
            $table->enum('tipe_file', ['pdf', 'link'])->default('pdf');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_submission_files');
    }
};
