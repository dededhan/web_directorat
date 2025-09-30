<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('matchmaking_submissions', function (Blueprint $table) {

            $table->json('status_history')->nullable()->after('status');
        });
    }


    public function down()
    {
        Schema::table('matchmaking_submissions', function (Blueprint $table) {
            $table->dropColumn('status_history');
        });
    }
};
