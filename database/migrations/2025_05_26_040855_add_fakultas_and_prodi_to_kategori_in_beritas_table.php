<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // The new, complete list of options
        DB::statement("ALTER TABLE beritas MODIFY COLUMN kategori ENUM('inovasi', 'pemeringkatan', 'umum', 'fakultas', 'prodi')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to the list before this change
        DB::statement("ALTER TABLE beritas MODIFY COLUMN kategori ENUM('inovasi', 'pemeringkatan', 'umum')");
    }
};