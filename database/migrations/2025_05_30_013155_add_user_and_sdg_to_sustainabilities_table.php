<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserAndSdgToSustainabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sustainabilities', function (Blueprint $table) {
            // Add user_id column, assuming you have a users table
            // Make it nullable if old records might not have it, or set a default
            // Ensure it's an unsigned big integer if your users table uses bigIncrements for id
            $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Or any other position
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Optional: set null on user deletion

            // Add sdg_goal column
            $table->string('sdg_goal')->nullable()->after('deskripsi_kegiatan'); // Or any other position
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sustainabilities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('sdg_goal');
        });
    }
}