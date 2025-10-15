<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Berita;
use App\Services\TranslationService;
use Illuminate\Support\Facades\Log;

class TranslateOldBerita extends Command
{
    protected $signature = 'berita:translate-old 
                            {--all : Translate all berita including those already translated}
                            {--limit= : Limit number of berita to translate}';

    protected $description = 'Auto translate old berita data from Indonesian to English';

    protected $translationService;

    public function __construct()
    {
        parent::__construct();
        $this->translationService = new TranslationService();
    }

    public function handle()
    {
        $this->info('Starting berita translation process...');

        // Build query
        $query = Berita::query();

        if (!$this->option('all')) {
            // Only translate berita that don't have translations yet
            $query->where(function($q) {
                $q->whereNull('judul_en')
                  ->orWhereNull('isi_en')
                  ->orWhere('judul_en', '')
                  ->orWhere('isi_en', '');
            });
        }

        // Apply limit if specified
        if ($limit = $this->option('limit')) {
            $query->limit((int)$limit);
        }

        $beritas = $query->get();
        $totalCount = $beritas->count();

        if ($totalCount === 0) {
            $this->info('No berita found to translate.');
            return Command::SUCCESS;
        }

        $this->info("Found {$totalCount} berita to translate.");

        $bar = $this->output->createProgressBar($totalCount);
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($beritas as $berita) {
            try {
                // Translate title if empty
                if (empty($berita->judul_en) || $this->option('all')) {
                    $berita->judul_en = $this->translationService->translateToEnglish($berita->judul);
                }

                // Translate content if empty
                if (empty($berita->isi_en) || $this->option('all')) {
                    $berita->isi_en = $this->translationService->translateHtml($berita->isi, 'en');
                }

                $berita->save();
                $successCount++;

                // Add small delay to avoid rate limiting
                usleep(100000); // 0.1 second delay

            } catch (\Exception $e) {
                $errorCount++;
                Log::error("Failed to translate berita ID {$berita->id}: " . $e->getMessage());
                $this->error("\nError translating berita ID {$berita->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Translation completed!");
        $this->info("Success: {$successCount}");
        
        if ($errorCount > 0) {
            $this->warn("Errors: {$errorCount}");
            $this->info("Check logs for detailed error information.");
        }

        return Command::SUCCESS;
    }
}
