<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE inov_chalenge_registrations MODIFY COLUMN role ENUM('dosen','alumni','peneliti','dudi','pppk','mahasiswa') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE inov_chalenge_registrations MODIFY COLUMN role ENUM('alumni','peneliti','dudi','pppk','mahasiswa') NOT NULL");
    }
};
