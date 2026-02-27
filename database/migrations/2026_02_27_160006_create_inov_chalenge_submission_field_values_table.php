<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inov_chalenge_submission_field_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inov_chalenge_submission_id');
            $table->unsignedBigInteger('inov_chalenge_tahap_id');
            $table->unsignedBigInteger('inov_chalenge_tahap_field_id');
            $table->text('value_text')->nullable();        // text, textarea, number, date, dropdown
            $table->string('value_file_path')->nullable(); // file upload
            $table->string('original_filename')->nullable();
            $table->text('value_url')->nullable();         // url type
            $table->timestamps();

            // Shortened FK names to stay within MySQL's 64-char limit
            $table->foreign('inov_chalenge_submission_id', 'sfv_submission_fk')
                ->references('id')->on('inov_chalenge_submissions')->cascadeOnDelete();
            $table->foreign('inov_chalenge_tahap_id', 'sfv_tahap_fk')
                ->references('id')->on('inov_chalenge_tahap')->cascadeOnDelete();
            $table->foreign('inov_chalenge_tahap_field_id', 'sfv_field_fk')
                ->references('id')->on('inov_chalenge_tahap_fields')->cascadeOnDelete();

            $table->unique(['inov_chalenge_submission_id', 'inov_chalenge_tahap_field_id'], 'sfv_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inov_chalenge_submission_field_values');
    }
};
