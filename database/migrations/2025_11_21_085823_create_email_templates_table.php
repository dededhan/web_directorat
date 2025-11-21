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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['academic', 'employee'])->comment('Responden category');
            $table->enum('language', ['en', 'id'])->comment('Email language: en=English, id=Indonesian');
            $table->string('subject', 500);
            $table->text('greeting');
            $table->text('body_intro');
            $table->text('body_main');
            $table->text('body_outro');
            $table->string('button_text', 100);
            $table->text('closing');
            $table->string('signature_name');
            $table->text('signature_title');
            $table->timestamps();
            $table->unique(['category', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
