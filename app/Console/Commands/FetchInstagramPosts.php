<?php

namespace App\Console\Commands;

use App\Http\Controllers\InstagramApiController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchInstagramPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store recent Instagram posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching Instagram posts...');
        
        try {
            $instagramController = new InstagramApiController();
            $result = $instagramController->fetchAndStoreInstagramPosts(3);
            
            if ($result['success']) {
                $this->info($result['message']);
                Log::info('Instagram fetch command completed: ' . $result['message']);
            } else {
                $this->error($result['message']);
                Log::error('Instagram fetch command failed: ' . $result['message']);
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error fetching Instagram posts: ' . $e->getMessage());
            Log::error('Error in Instagram fetch command: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}