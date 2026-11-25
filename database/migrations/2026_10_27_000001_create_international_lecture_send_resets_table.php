<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('international_lecture_send_resets')) {
            if (!Schema::hasColumn('international_lecture_send_resets', 'reset_date')) {
                Schema::dropIfExists('international_lecture_send_resets');
            } else {
                return;
            }
        }

        Schema::create('international_lecture_send_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_internasional_id')
                ->constrained('dosen_internasionals')
                ->cascadeOnDelete();
            $table->date('reset_date')->index();
            $table->timestamp('reset_at');
            $table->unsignedBigInteger('reset_by')->nullable();
            $table->timestamps();

            $table->unique(['dosen_internasional_id', 'reset_date'], 'il_send_reset_unique_date');
            $table->index(['reset_date', 'reset_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('international_lecture_send_resets');
    }
};
