<?php

namespace App\Http\Controllers;

use App\Models\InstagramApiPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramApiController extends Controller
{
    protected $accessToken;
    protected $apiUrl = 'https://graph.instagram.com/';
    
    public function __construct()
    {
        // Load the token from environment variable
        $this->accessToken = env('INSTAGRAM_ACCESS_TOKEN');
    }
    
    /**
     * Fetch recent media from Instagram API and store in database
     */
    public function fetchAndStoreInstagramPosts()
    {
        try {
            // Get user media from Instagram Graph API
            $response = Http::get($this->apiUrl . 'me/media', [
                'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
                'access_token' => $this->accessToken
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']) && is_array($data['data'])) {
                    foreach ($data['data'] as $post) {
                        // Only process IMAGE and CAROUSEL_ALBUM types
                        if ($post['media_type'] == 'IMAGE' || $post['media_type'] == 'CAROUSEL_ALBUM') {
                            // Check if this post already exists
                            $existingPost = InstagramApiPost::where('instagram_id', $post['id'])->first();
                            
                            if (!$existingPost) {
                                $mediaUrl = $post['media_url'] ?? ($post['thumbnail_url'] ?? null);
                                $caption = $post['caption'] ?? '';
                                
                                InstagramApiPost::create([
                                    'instagram_id' => $post['id'],
                                    'title' => substr($caption, 0, 100),
                                    'caption' => $caption,
                                    'media_url' => $mediaUrl,
                                    'permalink' => $post['permalink'],
                                    'posted_at' => $post['timestamp'],
                                    'is_active' => true
                                ]);
                            }
                        }
                    }
                    
                    return ['success' => true, 'message' => 'Instagram posts fetched and stored successfully'];
                }
            }
            
            return ['success' => false, 'message' => 'Failed to fetch Instagram posts: ' . ($response->json()['error']['message'] ?? 'Unknown error')];
        } catch (\Exception $e) {
            Log::error('Instagram fetch error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error fetching Instagram posts: ' . $e->getMessage()];
        }
    }
    
    /**
     * Get posts for frontend display
     */
    public function getPosts()
    {
        try {
            // First check if we have posts in the database
            $posts = InstagramApiPost::where('is_active', true)
                    ->orderBy('posted_at', 'desc')
                    ->take(6)
                    ->get();
            
            // If no posts, try to fetch them first
            if ($posts->isEmpty()) {
                $this->fetchAndStoreInstagramPosts();
                
                // Try to get posts again
                $posts = InstagramApiPost::where('is_active', true)
                        ->orderBy('posted_at', 'desc')
                        ->take(6)
                        ->get();
            }
            
            return response()->json($posts);
        } catch (\Exception $e) {
            Log::error('Error getting Instagram posts: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}