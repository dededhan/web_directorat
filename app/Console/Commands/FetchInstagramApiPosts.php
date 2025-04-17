<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\InstagramApiController;

class FetchInstagramApiPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:api:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch recent Instagram posts using the Instagram API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new InstagramApiController();
        
        $this->info('Fetching Instagram posts...');
        
        try {
            $result = $controller->fetchAndStoreInstagramPosts();
            
            if ($result['success']) {
                $this->info($result['message']);
                return 0;
            } else {
                $this->error($result['message']);
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error fetching Instagram posts: ' . $e->getMessage());
            return 1;
        }
    }
}