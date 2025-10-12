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
            if (!Schema::hasColumn('the_impact_contents', 'year')) {
                $table->year('year')->nullable()->after('link_url');
            }
            if (!Schema::hasIndex('the_impact_contents', 'year')) {
                $table->index('year');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('the_impact_contents', function (Blueprint $table) {
            $table->dropIndex(['year']);
            $table->dropColumn('year');
        });
    }
};
