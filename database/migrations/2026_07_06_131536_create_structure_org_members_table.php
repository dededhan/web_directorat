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
        Schema::create('structure_org_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable(); // Jabatan
            $table->string('photo')->nullable(); // Path foto
            $table->foreignId('parent_id')->nullable()->constrained('structure_org_members')->cascadeOnDelete();
            $table->integer('order')->default(1); // Untuk ordering siblings
            $table->integer('level')->default(1); // Tingkat hirarki
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_org_members');
    }
};
