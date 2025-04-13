<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Berita;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('judul');
        });

        // Update existing records to add slug
        $beritas = Berita::all();
        foreach ($beritas as $berita) {
            $slug = Str::slug($berita->judul);
            
            // Check if the slug already exists
            $count = 1;
            $originalSlug = $slug;
            while (Berita::where('slug', $slug)->where('id', '!=', $berita->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            
            $berita->slug = $slug;
            $berita->save();
        }

        // Add unique index after populating data
        Schema::table('beritas', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};