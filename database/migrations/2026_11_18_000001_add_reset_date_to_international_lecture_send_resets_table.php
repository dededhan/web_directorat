<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('international_lecture_send_resets')) {
            Schema::table('international_lecture_send_resets', function (Blueprint $table) {
                if (!Schema::hasColumn('international_lecture_send_resets', 'reset_date')) {
                    $table->date('reset_date')->nullable()->after('dosen_internasional_id')->index();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('international_lecture_send_resets')) {
            Schema::table('international_lecture_send_resets', function (Blueprint $table) {
                if (Schema::hasColumn('international_lecture_send_resets', 'reset_date')) {
                    $table->dropColumn('reset_date');
                }
            });
        }
    }
};
