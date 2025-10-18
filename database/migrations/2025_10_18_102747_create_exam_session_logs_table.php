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
        Schema::create('exam_session_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('exam_session_id');
            $table->foreign('exam_session_id')->references('id')->on('exam_sessions')->onDelete('cascade');
            $table->string('activity_type'); // tab_switch, answer_change, copy_attempt, etc
            $table->json('metadata')->nullable(); // additional details
            $table->timestamp('logged_at');
            
            $table->index('exam_session_id');
            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_session_logs');
    }
};
