<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_tahap_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inov_chalenge_tahap_id')
                ->constrained('inov_chalenge_tahap')
                ->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_tahap_sections');
    }
};
