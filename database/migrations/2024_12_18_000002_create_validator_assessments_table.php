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
        Schema::create('validator_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->unsignedBigInteger('katsinov_category_id');
            $table->unsignedBigInteger('katsinov_indicator_id');
            $table->decimal('dosen_score', 5, 2)->nullable()->comment('Skor yang diberikan dosen');
            $table->decimal('validator_score', 5, 2)->nullable()->comment('Skor yang diberikan validator');
            $table->decimal('bobot', 5, 2)->nullable()->comment('Bobot indikator');
            $table->enum('status', ['draft', 'submitted'])->default('draft');
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('innovator_forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('katsinov_category_id')->references('id')->on('katsinov_categories')->onDelete('cascade');
            $table->foreign('katsinov_indicator_id')->references('id')->on('katsinov_indicators')->onDelete('cascade');

            // Indexes
            $table->index(['form_id', 'validator_id'], 'idx_assessment_form_validator');
            $table->index('katsinov_category_id', 'idx_category');
            $table->unique(['form_id', 'validator_id', 'katsinov_indicator_id'], 'unique_assessment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_assessments');
    }
};
