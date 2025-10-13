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
        Schema::table('settings', function (Blueprint $table) {
            $table->decimal('threshold_indicator_1', 5, 2)->default(0.00)->after('value');
            $table->decimal('threshold_indicator_2', 5, 2)->default(0.00)->after('threshold_indicator_1');
            $table->decimal('threshold_indicator_3', 5, 2)->default(0.00)->after('threshold_indicator_2');
            $table->decimal('threshold_indicator_4', 5, 2)->default(0.00)->after('threshold_indicator_3');
            $table->decimal('threshold_indicator_5', 5, 2)->default(0.00)->after('threshold_indicator_4');
            $table->decimal('threshold_indicator_6', 5, 2)->default(0.00)->after('threshold_indicator_5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'threshold_indicator_1',
                'threshold_indicator_2',
                'threshold_indicator_3',
                'threshold_indicator_4',
                'threshold_indicator_5',
                'threshold_indicator_6'
            ]);
        });
    }
};
