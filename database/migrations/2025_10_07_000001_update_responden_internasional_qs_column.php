<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presenting_submissions', function (Blueprint $table) {
            $table->json('responden_internasional_qs')->nullable()->after('sp_setneg_path');
        });

        Schema::table('presenting_submissions', function (Blueprint $table) {
            $table->dropColumn('responden_internasional_qs_path');
        });
    }

    public function down(): void
    {
        Schema::table('presenting_submissions', function (Blueprint $table) {
            $table->dropColumn('responden_internasional_qs');
        });

        Schema::table('presenting_submissions', function (Blueprint $table) {
            $table->string('responden_internasional_qs_path')->nullable()->after('sp_setneg_path');
        });
    }
};
