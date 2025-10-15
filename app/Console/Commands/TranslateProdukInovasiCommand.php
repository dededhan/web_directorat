<?php

namespace App\Console\Commands;

use App\Models\ProdukInovasi;
use App\Services\TranslationService;
use Illuminate\Console\Command;

class TranslateProdukInovasiCommand extends Command
{
    protected $signature = 'produk-inovasi:translate {--force : Force re-translate all records}';
    protected $description = 'Auto-translate existing produk inovasi records to English';

    public function handle()
    {
        $this->info('Starting translation process...');
        
        $translationService = new TranslationService();
        
        $query = ProdukInovasi::query();
        
        if (!$this->option('force')) {
            $query->where(function($q) {
                $q->whereNull('nama_produk_en')
                  ->orWhereNull('inovator_en')
                  ->orWhereNull('deskripsi_en');
            });
        }
        
        $products = $query->get();
        
        if ($products->isEmpty()) {
            $this->info('No products need translation.');
            return 0;
        }
        
        $this->info("Found {$products->count()} product(s) to translate.");
        
        $progressBar = $this->output->createProgressBar($products->count());
        $progressBar->start();
        
        $successCount = 0;
        $failCount = 0;
        
        foreach ($products as $product) {
            try {
                $updated = false;
                
                if (empty($product->nama_produk_en) || $this->option('force')) {
                    $product->nama_produk_en = $translationService->translate($product->nama_produk);
                    $updated = true;
                }
                
                if (empty($product->inovator_en) || $this->option('force')) {
                    $product->inovator_en = $translationService->translate($product->inovator);
                    $updated = true;
                }
                
                if (empty($product->deskripsi_en) || $this->option('force')) {
                    $product->deskripsi_en = $translationService->translateHtml($product->deskripsi);
                    $updated = true;
                }
                
                if ($updated) {
                    $product->save();
                    $successCount++;
                }
                
            } catch (\Exception $e) {
                $this->error("\nFailed to translate product ID {$product->id}: {$e->getMessage()}");
                $failCount++;
            }
            
            $progressBar->advance();
            sleep(1); // Delay to avoid hitting API rate limits
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        $this->info("Translation completed!");
        $this->info("✓ Success: {$successCount}");
        if ($failCount > 0) {
            $this->warn("✗ Failed: {$failCount}");
        }
        
        return 0;
    }
}
