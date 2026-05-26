<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presenting_submissions', function (Blueprint $table) {
            $table->string('manuscript_path')->nullable()->after('responden_internasional_qs');
            $table->string('manuscript_link')->nullable()->after('manuscript_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presenting_submissions', function (Blueprint $table) {
            $table->dropColumn(['manuscript_path', 'manuscript_link']);
        });
    }
};
