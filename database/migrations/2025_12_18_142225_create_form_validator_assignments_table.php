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
        Schema::create('form_validator_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('innovator_forms')->onDelete('cascade');
            $table->foreignId('validator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('assigned_at')->useCurrent();
            $table->text('notes')->nullable()->comment('Catatan assignment dari admin');
            $table->timestamps();

            $table->unique(['form_id', 'validator_id'], 'unique_form_validator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_validator_assignments');
    }
};
