<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comdev_submission_files', function (Blueprint $table) {
            $table->string('judul_luaran')->nullable()->after('type');
            $table->string('status_luaran')->nullable()->after('judul_luaran');
        });
    }

    public function down()
    {
        Schema::table('comdev_submission_files', function (Blueprint $table) {
            $table->dropColumn(['judul_luaran', 'status_luaran']);
        });
    }
};
