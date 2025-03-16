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
        Schema::create('katsinov_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('katsinov_id')->constrained();
            $table->integer('indicator_number');
            $table->integer('row_number');
            $table->string('aspect', 2);
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_responses');
    }
};
