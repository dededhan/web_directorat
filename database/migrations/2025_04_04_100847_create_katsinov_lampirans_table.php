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
        Schema::create('katsinov_lampirans', function (Blueprint $table) {
            $table->id();
            $table->text('path');
            $table->string('category');
            $table->string('type');
            $table->foreignId('katsinov_id')->references('id')->on('katsinovs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_lampirans');
    }
};
