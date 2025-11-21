<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        // First, iterate over existing products with video paths and move them to the new table
        DB::table('produk_inovasi')->whereNotNull('video_path')->where('video_path', '!=', '')->orderBy('id')->each(function ($produk) {
            DB::table('produk_inovasi_videos')->insert([
                'produk_inovasi_id' => $produk->id,
                'type' => $produk->video_type ?? 'youtube', // Default to youtube if type is somehow null
                'path' => $produk->video_path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        // After migrating data, drop the old columns
        Schema::table('produk_inovasi', function (Blueprint $table) {
            $table->dropColumn('video_type');
            $table->dropColumn('video_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add the columns back
        Schema::table('produk_inovasi', function (Blueprint $table) {
            $table->string('video_type')->nullable()->after('foto_poster');
            $table->string('video_path')->nullable()->after('video_type');
        });

        // This is a simple reversal, it doesn't restore the data from the new table to the old columns.
        // Data loss on rollback is expected unless a more complex rollback is written.
    }
};