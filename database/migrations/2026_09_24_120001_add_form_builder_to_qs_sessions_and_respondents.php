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
        Schema::table('qs_sessions', function (Blueprint $table) {
            $table->enum('mode', ['consent_only', 'form_based'])->default('consent_only')->after('name');
            $table->json('academic_form_schema')->nullable()->after('custom_fields_schema');
            $table->json('employee_form_schema')->nullable()->after('academic_form_schema');
        });

        Schema::table('qs_session_respondents', function (Blueprint $table) {
            $table->json('form_answers')->nullable()->after('custom_fields');
            $table->timestamp('form_submitted_at')->nullable()->after('consented_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qs_sessions', function (Blueprint $table) {
            $table->dropColumn(['mode', 'academic_form_schema', 'employee_form_schema']);
        });

        Schema::table('qs_session_respondents', function (Blueprint $table) {
            $table->dropColumn(['form_answers', 'form_submitted_at']);
        });
    }
};
