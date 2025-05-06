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
        Schema::table('alumni_berdampak', function (Blueprint $table) {
            $table->dropColumn('prodi');
        });
    }
    
    public function down()
    {
        Schema::table('alumni_berdampak', function (Blueprint $table) {
            $table->string('prodi')->after('fakultas');
        });
    }
};
