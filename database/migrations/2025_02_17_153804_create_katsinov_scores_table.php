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
        Schema::create('katsinov_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('katsinov_id')->references('id')->on('katsinovs');
            $table->integer('indicator_number');
            $table->decimal('technology', 5, 2);
            $table->decimal('organization', 5, 2);
            $table->decimal('risk', 5, 2);
            $table->decimal('market', 5, 2);
            $table->decimal('partnership', 5, 2);
            $table->decimal('manufacturing', 5, 2);
            $table->decimal('investment', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_scores');
    }
};
