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
        Schema::create('responden_bank', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('title', 20)->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('institution')->nullable();
            $table->string('department')->nullable();
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->string('country')->default('Indonesia')->nullable();
            $table->string('phone', 50)->nullable();
            $table->enum('category', ['academic', 'employee'])->nullable();
            $table->json('custom_fields')->nullable();
            $table->enum('source', ['manual', 'import', 'legacy_migration', 'form_submission'])->default('manual');
            $table->foreignId('source_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responden_bank');
    }
};
