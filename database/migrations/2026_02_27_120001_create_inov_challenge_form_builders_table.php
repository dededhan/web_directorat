<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_challenge_form_builders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('inov_challenge_sessions')->onDelete('cascade');
            $table->enum('phase', ['phase_1', 'phase_2', 'phase_3']);
            $table->json('form_config');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_challenge_form_builders');
    }
};
