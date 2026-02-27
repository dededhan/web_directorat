<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inov_chalenge_sessions', function (Blueprint $table) {
            $table->decimal('dana_minimal', 15, 2)->nullable()->after('dana_maksimal');
        });
    }

    public function down(): void
    {
        Schema::table('inov_chalenge_sessions', function (Blueprint $table) {
            $table->dropColumn('dana_minimal');
        });
    }
};
