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
        Schema::table('katsinov_responses', function (Blueprint $table) {
            $table->string('dropdown_value', 1)->nullable()->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('katsinov_responses', function (Blueprint $table) {
            $table->dropColumn('dropdown_value');
        });
    }
};
