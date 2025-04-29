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
        Schema::create('katsinov_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('katsinov_id');
            $table->unsignedInteger('indicator_number'); // 1-6 corresponding to the indicators
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('katsinov_id')
                  ->references('id')
                  ->on('katsinovs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_notes');
    }
};
