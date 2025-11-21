<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            // Add new combined content field
            $table->text('email_content')->after('greeting')->nullable();
        });

        // Migrate existing data
        DB::table('email_templates')->get()->each(function ($template) {
            $combinedContent = implode("\n\n", array_filter([
                $template->body_intro,
                $template->body_main,
                $template->body_outro,
            ]));
            
            DB::table('email_templates')
                ->where('id', $template->id)
                ->update(['email_content' => $combinedContent]);
        });

        // Drop old columns
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn(['body_intro', 'body_main', 'body_outro']);
        });

        // Make email_content not nullable
        Schema::table('email_templates', function (Blueprint $table) {
            $table->text('email_content')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            // Add back old columns
            $table->text('body_intro')->after('greeting');
            $table->text('body_main')->after('body_intro');
            $table->text('body_outro')->after('body_main');
        });

        // Split content back (basic split)
        DB::table('email_templates')->get()->each(function ($template) {
            $parts = explode("\n\n", $template->email_content, 3);
            
            DB::table('email_templates')
                ->where('id', $template->id)
                ->update([
                    'body_intro' => $parts[0] ?? '',
                    'body_main' => $parts[1] ?? '',
                    'body_outro' => $parts[2] ?? '',
                ]);
        });

        // Drop new column
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn('email_content');
        });
    }
};
