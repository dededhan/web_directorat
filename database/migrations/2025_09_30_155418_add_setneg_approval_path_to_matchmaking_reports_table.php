<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matchmaking_reports', function (Blueprint $table) {
            $table->string('setneg_approval_path')->nullable()->after('travel_proof_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matchmaking_reports', function (Blueprint $table) {
            $table->dropColumn('setneg_approval_path');
        });
    }
};
