<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sustainabilities', function (Blueprint $table) {
            $table->string('sdg_target')->nullable()->after('deskripsi_kegiatan');
        });
    }

    public function down()
    {
        Schema::table('sustainabilities', function (Blueprint $table) {
            $table->dropColumn('sdg_target');
        });
    }
};