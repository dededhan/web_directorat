<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('international_lecture_greetings', function (Blueprint $table) {
            $table->id();
            $table->uuid('batch_id')->index();
            $table->string('greeting_type', 50)->index();
            $table->string('subject');
            $table->longText('message');
            $table->foreignId('lecturer_id')->nullable()->constrained('dosen_internasionals')->nullOnDelete();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_email')->index();
            $table->string('email_status', 30)->default('not_sent')->index();
            $table->timestamp('email_sent_at')->nullable();
            $table->text('email_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('international_lecture_greetings');
    }
};
