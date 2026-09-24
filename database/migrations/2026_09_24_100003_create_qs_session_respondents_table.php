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
        Schema::create('qs_session_respondents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qs_session_id')->constrained('qs_sessions')->cascadeOnDelete();
            $table->foreignId('responden_bank_id')->constrained('responden_bank')->cascadeOnDelete();
            $table->enum('category', ['academic', 'employee']);
            $table->timestamp('email_sent_at')->nullable();
            $table->integer('email_count')->default(0);
            $table->enum('consent_status', ['pending', 'agreed', 'expired'])->default('pending');
            $table->timestamp('consented_at')->nullable();
            $table->string('consent_ip', 45)->nullable();
            $table->string('token', 64)->unique()->nullable();
            $table->timestamps();

            $table->unique(['qs_session_id', 'responden_bank_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qs_session_respondents');
    }
};
