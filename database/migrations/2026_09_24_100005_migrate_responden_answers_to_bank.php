<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Migrate unique responden_answers data into responden_bank.
     * For duplicate emails, the most recent record's data is used.
     */
    public function up(): void
    {
        $answers = DB::table('responden_answers')
            ->orderBy('created_at', 'desc')
            ->get();

        $processedEmails = [];
        $imported = 0;
        $skipped = 0;

        foreach ($answers as $answer) {
            $email = strtolower(trim($answer->email));

            if (empty($email) || isset($processedEmails[$email])) {
                $skipped++;
                continue;
            }

            $processedEmails[$email] = true;

            // Normalize category
            $category = strtolower(trim($answer->category ?? ''));
            $normalizedCategory = match (true) {
                in_array($category, ['academic', 'researcher']) => 'academic',
                in_array($category, ['employee', 'employer', 'industri']) => 'employee',
                default => null,
            };

            DB::table('responden_bank')->insertOrIgnore([
                'email' => $email,
                'title' => $answer->title ?? null,
                'first_name' => $answer->first_name ?? 'Unknown',
                'last_name' => $answer->last_name ?? null,
                'job_title' => $answer->job_title ?? null,
                'institution' => $answer->institution ?? null,
                'department' => $answer->department ?? null,
                'company_name' => $answer->company_name ?? null,
                'position' => $answer->position ?? null,
                'country' => $answer->country ?? 'Indonesia',
                'phone' => $answer->phone ?? null,
                'category' => $normalizedCategory,
                'source' => 'legacy_migration',
                'source_user_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $imported++;
        }

        Log::info("RespondenBank migration complete: {$imported} imported, {$skipped} skipped (duplicates/empty emails).");
    }

    /**
     * Reverse the migrations.
     * Only removes legacy_migration entries, not manually added ones.
     */
    public function down(): void
    {
        DB::table('responden_bank')
            ->where('source', 'legacy_migration')
            ->delete();
    }
};
