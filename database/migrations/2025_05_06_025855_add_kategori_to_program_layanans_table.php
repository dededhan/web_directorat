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
        Schema::table('program_layanans', function (Blueprint $table) {
            $table->enum('kategori', ['direktorat', 'pemeringkatan', 'inovasi'])
                  ->default('direktorat')
                  ->after('deskripsi');
        });
    }
    
    public function down()
    {
        Schema::table('program_layanans', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
