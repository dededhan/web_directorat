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
        Schema::create('instagram_api_posts', function (Blueprint $table) {
            $table->id();
            $table->string('instagram_id')->unique();
            $table->string('title');
            $table->text('caption')->nullable();
            $table->text('media_url')->nullable();
            $table->string('permalink');
            $table->timestamp('posted_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_api_posts');
    }
};