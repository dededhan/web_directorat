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
        Schema::create('katsinov_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('katsinov_categories')->onDelete('cascade');
            $table->string('code', 50)->comment('e.g., K1.1, K1.2, K2.1');
            $table->string('name')->comment('Indicator name');
            $table->text('description')->nullable();
            $table->decimal('weight', 5, 2)->default(0)->comment('Weight within category');
            $table->integer('max_score')->default(5)->comment('Maximum score for this indicator');
            $table->integer('order')->default(0)->comment('Display order within category');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['category_id', 'code'], 'unique_category_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katsinov_indicators');
    }
};
