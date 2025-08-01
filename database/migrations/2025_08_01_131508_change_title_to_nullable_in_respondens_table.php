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
    public function up(): void
    {
        // Select the 'respondens' table to apply changes
        Schema::table('respondens', function (Blueprint $table) {
            // Modify the 'title' column to allow null values.
            // The change() method is used to alter an existing column's attributes.
            $table->string('title', 4)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Revert the changes made in the 'up' method
        Schema::table('respondens', function (Blueprint $table) {
            // Change the 'title' column back to being non-nullable.
            // Note: If you have null values in the database, this rollback will fail.
            // You would need to update the data to remove nulls before reverting.
            $table->string('title', 4)->nullable(false)->change();
        });
    }
};
