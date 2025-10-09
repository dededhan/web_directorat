<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('the_impact_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sdg_id')->constrained('the_impact_sdgs')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('the_impact_contents')->onDelete('cascade');
            $table->string('point_number');
            $table->string('title');
            $table->enum('content_type', ['text', 'link']);
            $table->longText('content')->nullable();
            $table->string('link_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('the_impact_contents');
    }
};
