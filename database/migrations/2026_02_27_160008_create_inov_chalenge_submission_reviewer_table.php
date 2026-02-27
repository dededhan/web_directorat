<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_submission_reviewer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->timestamps();

            $table->foreign('inov_chalenge_submission_id', 'srv_submission_fk')
                ->references('id')->on('inov_chalenge_submissions')->cascadeOnDelete();
            $table->foreign('reviewer_id', 'srv_reviewer_fk')
                ->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['inov_chalenge_submission_id', 'reviewer_id'], 'sr_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_submission_reviewer');
    }
};
