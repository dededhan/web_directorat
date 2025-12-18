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
        Schema::create('validator_agreements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->longText('signature_data')->comment('Base64 encoded signature');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('agreed_at')->useCurrent();
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('innovator_forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes
            $table->index(['form_id', 'validator_id'], 'idx_form_validator');
            $table->unique(['form_id', 'validator_id'], 'unique_agreement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_agreements');
    }
};
