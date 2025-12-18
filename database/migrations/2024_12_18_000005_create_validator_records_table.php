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
        Schema::create('validator_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->text('executive_summary')->nullable();
            $table->text('strengths')->nullable()->comment('Kekuatan/Strengths');
            $table->text('weaknesses')->nullable()->comment('Kelemahan/Weaknesses');
            $table->text('opportunities')->nullable()->comment('Peluang/Opportunities');
            $table->text('threats')->nullable()->comment('Ancaman/Threats');
            $table->text('improvement_suggestions')->nullable();
            $table->text('implementation_recommendations')->nullable();
            $table->text('final_notes')->nullable();
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('innovator_forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->unique(['form_id', 'validator_id'], 'unique_validator_record');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_records');
    }
};
