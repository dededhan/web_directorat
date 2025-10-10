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
        Schema::create('modul_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_modul_id')->constrained('proposal_modul')->onDelete('cascade');
            $table->foreignId('modul_sub_chapter_id')->nullable()->constrained('modul_sub_chapter')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->text('komentar');
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_reviews');
    }
};
