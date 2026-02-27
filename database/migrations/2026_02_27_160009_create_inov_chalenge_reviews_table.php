<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            $table->unsignedBigInteger('inov_chalenge_tahap_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->text('komentar');
            $table->text('penilaian')->nullable();
            $table->timestamps();

            $table->foreign('inov_chalenge_submission_id', 'rev_submission_fk')
                ->references('id')->on('inov_chalenge_submissions')->cascadeOnDelete();
            $table->foreign('inov_chalenge_tahap_id', 'rev_tahap_fk')
                ->references('id')->on('inov_chalenge_tahap')->cascadeOnDelete();
            $table->foreign('reviewer_id', 'rev_reviewer_fk')
                ->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_reviews');
    }
};
