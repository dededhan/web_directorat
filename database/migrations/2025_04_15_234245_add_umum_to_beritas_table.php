<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Untuk MySQL
        DB::statement("ALTER TABLE beritas MODIFY COLUMN kategori ENUM('inovasi', 'pemeringkatan', 'umum')");

        // Atau untuk PostgreSQL
        // DB::statement("ALTER TABLE beritas ALTER COLUMN kategori TYPE VARCHAR(255)");
        // DB::statement("ALTER TABLE beritas ADD CONSTRAINT kategori_check CHECK (kategori IN ('inovasi', 'pemeringkatan', 'umum'))");
    }

    public function down()
    {
        // Untuk MySQL
        DB::statement("ALTER TABLE beritas MODIFY COLUMN kategori ENUM('inovasi', 'pemeringkatan')");

        // Untuk PostgreSQL
        // DB::statement("ALTER TABLE beritas DROP CONSTRAINT kategori_check");
        // DB::statement("ALTER TABLE beritas ALTER COLUMN kategori TYPE VARCHAR(255)");
        // DB::statement("ALTER TABLE beritas ADD CONSTRAINT kategori_check CHECK (kategori IN ('inovasi', 'pemeringkatan'))");
    }
};