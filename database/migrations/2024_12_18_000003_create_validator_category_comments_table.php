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
        Schema::create('validator_category_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('validator_id');
            $table->unsignedBigInteger('katsinov_category_id');
            $table->text('comment')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('innovator_forms')->onDelete('cascade');
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('katsinov_category_id')->references('id')->on('katsinov_categories')->onDelete('cascade');

            // Indexes
            $table->unique(['form_id', 'validator_id', 'katsinov_category_id'], 'unique_category_comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validator_category_comments');
    }
};
