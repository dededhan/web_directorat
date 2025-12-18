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
        Schema::create('katsinov_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique()->comment('e.g., K1, K2, K3, K4, K5');
            $table->string('name')->comment('Category name');
            $table->text('description')->nullable();
            $table->decimal('weight', 5, 2)->default(20.00)->comment('Weight percentage for scoring');
            $table->integer('order')->default(0)->comment('Display order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_categories');
    }
};
