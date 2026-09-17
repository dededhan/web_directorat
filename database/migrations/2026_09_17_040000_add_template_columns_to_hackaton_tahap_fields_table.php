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
        Schema::table('hackaton_tahap_fields', function (Blueprint $table) {
            $table->text('template_url')->nullable()->after('is_required');
            $table->string('template_file')->nullable()->after('template_url');
            $table->string('template_file_name')->nullable()->after('template_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hackaton_tahap_fields', function (Blueprint $table) {
            $table->dropColumn(['template_url', 'template_file', 'template_file_name']);
        });
    }
};
