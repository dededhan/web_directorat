<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_challenge_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('inov_challenge_submissions')->onDelete('cascade');
            $table->enum('phase', ['phase_1', 'phase_2', 'phase_3']);
            $table->string('file_name', 255);
            $table->string('file_path', 500);
            $table->string('file_type', 50);
            $table->integer('file_size'); // in bytes
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_challenge_uploads');
    }
};
