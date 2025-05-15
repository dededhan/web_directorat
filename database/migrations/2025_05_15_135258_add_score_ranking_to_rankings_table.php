<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->string('score_ranking')->nullable()->after('judul');
        });
    }

    public function down()
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->dropColumn('score_ranking');
        });
    }
};
