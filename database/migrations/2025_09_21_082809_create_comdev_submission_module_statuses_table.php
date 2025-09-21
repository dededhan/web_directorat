<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comdev_submission_module_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comdev_submission_id')->constrained('comdev_submissions')->onDelete('cascade');
            $table->foreignId('comdev_module_id')->constrained('comdev_modules')->onDelete('cascade');
            $table->string('status')->default('proses');
            $table->decimal('nominal_evaluasi', 15, 2)->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->unique(['comdev_submission_id', 'comdev_module_id'], 'submission_module_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comdev_submission_module_statuses');
    }
};
