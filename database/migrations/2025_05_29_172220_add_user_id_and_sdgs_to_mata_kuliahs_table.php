<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdAndSdgsToMataKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            // Menambahkan foreign key untuk user_id setelah kolom 'id'
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            // Menambahkan kolom untuk grup SDGs setelah kolom 'deskripsi'
            $table->string('sdgs_group')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            // Hapus foreign key constraint sebelum menghapus kolom
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('sdgs_group');
        });
    }
}