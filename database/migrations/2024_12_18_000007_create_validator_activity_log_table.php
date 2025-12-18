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
        Schema::create('validator_activity_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->string('action', 100)->comment('e.g., agreement_signed, assessment_saved, draft_saved, submitted');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable()->comment('Additional data in JSON format');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('innovator_forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['form_id', 'validator_id'], 'idx_log_form_validator');
            $table->index('action', 'idx_action');
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_activity_log');
    }
};
