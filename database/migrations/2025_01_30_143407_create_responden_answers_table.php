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
        Schema::create('responden_answers', function (Blueprint $table) {
            $table->id();
            // $table->foreign('id_responden')->references('id')->on('respondens');
            $table->string('title', 10);
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('job_title');
            $table->string('institution');
            $table->string('company_name');
            $table->string('country')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('survey_2023', ['yes', 'no'])->default('no');
            $table->enum('survey_2024', ['yes', 'no'])->default('no');
            $table->enum('category', ['academic', 'employee'])->nullable();
            $table->timestamps();  // Menambahkan nullable untuk timestamp
            // $table->enum('status', ['belum di-email', 'sudah di-email, belum di-follow up', 'sudah di-email, sudah di-follow up', 'selesai'])->default('belum di-email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responden_answers');
    }
};
