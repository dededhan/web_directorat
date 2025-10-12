<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert existing data from text to JSON array
        $contents = DB::table('the_impact_contents')
            ->whereNotNull('link_url')
            ->where('link_url', '!=', '')
            ->get();

        foreach ($contents as $content) {
            $links = array_filter(array_map('trim', explode("\n", $content->link_url)));
            $jsonLinks = json_encode(array_values($links));
            
            DB::table('the_impact_contents')
                ->where('id', $content->id)
                ->update(['link_url' => $jsonLinks]);
        }

        // Then modify the column type to JSON
        Schema::table('the_impact_contents', function (Blueprint $table) {
            $table->json('link_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert JSON back to text (newline separated)
        $contents = DB::table('the_impact_contents')
            ->whereNotNull('link_url')
            ->get();

        Schema::table('the_impact_contents', function (Blueprint $table) {
            $table->string('link_url', 255)->nullable()->change();
        });

        foreach ($contents as $content) {
            try {
                $links = json_decode($content->link_url, true);
                if (is_array($links)) {
                    $textLinks = implode("\n", $links);
                    DB::table('the_impact_contents')
                        ->where('id', $content->id)
                        ->update(['link_url' => $textLinks]);
                }
            } catch (\Exception $e) {
                // Keep original if conversion fails
            }
        }
    }
};
