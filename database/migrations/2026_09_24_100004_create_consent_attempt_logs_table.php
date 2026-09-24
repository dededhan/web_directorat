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
        Schema::create('consent_attempt_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('qs_session_id')->nullable()->constrained('qs_sessions')->nullOnDelete();
            $table->foreignId('responden_bank_id')->nullable()->constrained('responden_bank')->nullOnDelete();
            $table->string('token_used', 64)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('attempted_at')->useCurrent();
            $table->enum('result', ['already_consented', 'already_in_bank', 'success']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consent_attempt_logs');
    }
};
