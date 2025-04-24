<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_layanans', function (Blueprint $table) {
            if (!Schema::hasColumn('program_layanans', 'image')) {
                $table->string('image')->nullable()->after('icon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('program_layanans', function (Blueprint $table) {
            if (Schema::hasColumn('program_layanans', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};