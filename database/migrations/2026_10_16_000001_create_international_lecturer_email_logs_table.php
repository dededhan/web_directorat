<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('international_lecturer_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_internasional_id')
                ->nullable()
                ->constrained('dosen_internasionals')
                ->nullOnDelete();
            $table->uuid('batch_id')->nullable()->index();
            $table->string('recipient_email');
            $table->string('mode', 20)->default('template'); // template | manual
            $table->string('language_mode', 20)->nullable();
            $table->string('subject')->nullable();
            $table->string('status', 20)->default('queued')->index(); // queued | sending | sent | failed
            $table->text('error')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('international_lecturer_email_logs');
    }
};
