<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_layanans', function (Blueprint $table) {
            // Add the new 'url' column. It should be a string, nullable (since it's optional),
            // and placed after the 'judul' column for organization.
            $table->string('url')->nullable()->after('judul');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_layanans', function (Blueprint $table) {
            // This will remove the column if you ever need to rollback the migration.
            $table->dropColumn('url');
        });
    }
};