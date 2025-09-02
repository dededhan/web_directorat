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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('duration'); // in menit
            $table->foreignId('question_bank_id')->constrained('question_banks')->onDelete('cascade');
            $table->integer('number_of_questions');
            // $table->enum('status', ['draft', 'published', 'ongoing', 'finished'])->default('draft'); gw bingung wak, ini butuh gak ye?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
