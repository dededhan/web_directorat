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
            $table->json('custom_fields_schema')->nullable()->after('description');
        });

        Schema::table('qs_session_respondents', function (Blueprint $table) {
            $table->json('custom_fields')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qs_sessions', function (Blueprint $table) {
            $table->dropColumn('custom_fields_schema');
        });

        Schema::table('qs_session_respondents', function (Blueprint $table) {
            $table->dropColumn('custom_fields');
        });
    }
};
