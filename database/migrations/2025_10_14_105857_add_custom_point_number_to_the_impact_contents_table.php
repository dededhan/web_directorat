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
        Schema::table('the_impact_contents', function (Blueprint $table) {
            $table->string('custom_point_number')->nullable()->after('point_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('the_impact_contents', function (Blueprint $table) {
            $table->dropColumn('custom_point_number');
        });
    }
};
