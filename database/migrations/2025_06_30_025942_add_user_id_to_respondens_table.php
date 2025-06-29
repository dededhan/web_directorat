<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_user_id_to_respondens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToRespondensTable extends Migration
{
    public function up()
    {
        Schema::table('respondens', function (Blueprint $table) {
            // Add the user_id column. It can be nullable in case some records are system-generated
            // or if a user is deleted, we don't want to lose the respondent data.
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('respondens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}