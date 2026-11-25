<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('international_lecture_send_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_internasional_id')
                ->constrained('dosen_internasionals')
                ->cascadeOnDelete();
            $table->string('year_month', 7)->index();
            $table->timestamp('reset_at');
            $table->unsignedBigInteger('reset_by')->nullable();
            $table->timestamps();

            $table->unique(['dosen_internasional_id', 'year_month'], 'il_send_reset_unique');
            $table->index(['year_month', 'reset_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('international_lecture_send_resets');
    }
};
