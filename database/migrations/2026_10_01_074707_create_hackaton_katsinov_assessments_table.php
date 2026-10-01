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
        Schema::create('hackaton_katsinov_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hackaton_submission_id')->nullable()->constrained('hackaton_submissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_inovasi');
            $table->string('fokus_bidang')->nullable();
            $table->string('nama_tim')->nullable();
            $table->string('institusi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->date('assessment_date')->nullable();
            $table->unsignedTinyInteger('achieved_level')->default(0);
            $table->decimal('overall_percentage', 5, 2)->default(0);
            $table->json('aspect_scores')->nullable();
            $table->json('indicator_scores')->nullable();
            $table->longText('responses')->nullable();
            $table->json('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hackaton_katsinov_assessments');
    }
};
