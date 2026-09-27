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
            $table->json('email_settings')->nullable()->after('employee_form_schema');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qs_sessions', function (Blueprint $table) {
            $table->dropColumn('email_settings');
        });
    }
};
