<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_tahap_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inov_chalenge_tahap_id')
                ->constrained('inov_chalenge_tahap')
                ->cascadeOnDelete();
            $table->string('field_label');
            $table->enum('field_type', ['text', 'textarea', 'number', 'date', 'dropdown', 'checkbox', 'file', 'url']);
            $table->json('field_options')->nullable(); // for dropdown: array of option strings
            $table->boolean('is_required')->default(true);
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_tahap_fields');
    }
};
