<?php

namespace App\Http\Controllers;

use App\Models\InstagramApiPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class InstagramApiController extends Controller
{
    protected $accessToken;
    protected $apiUrl = 'https://graph.instagram.com/';
    
    public function __construct()
    {
        $this->accessToken = env('INSTAGRAM_ACCESS_TOKEN');
    }
    
    /**
     * Fetch recent media from Instagram API and store in database with improved error handling
     * @param int $retryCount Number of retry attempts
     * @return array Status result
     */
    public function fetchAndStoreInstagramPosts($retryCount = 3)
    {
        $attempt = 0;
        
        while ($attempt < $retryCount) {
            try {
                // Set timeout to avoid hanging requests
                $response = Http::timeout(30)->get($this->apiUrl . 'me/media', [
                    'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
                    'access_token' => $this->accessToken
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['data']) && is_array($data['data'])) {
                        $addedCount = 0;
                        $updatedCount = 0;
                        
                        foreach ($data['data'] as $post) {
                            // Only process IMAGE and CAROUSEL_ALBUM types
                            if ($post['media_type'] == 'IMAGE' || $post['media_type'] == 'CAROUSEL_ALBUM') {
                                $mediaUrl = $post['media_url'] ?? ($post['thumbnail_url'] ?? null);
                                $caption = $post['caption'] ?? '';
                                
                                // Check if media URL exists
                                if (!$mediaUrl) {
                                    Log::warning("No media URL for Instagram post {$post['id']}");
                                    continue;
                                }
                                
                                // Try to validate the media URL
                                try {
                                    $mediaCheck = Http::timeout(5)->head($mediaUrl);
                                    if (!$mediaCheck->successful()) {
                                        Log::warning("Invalid media URL for Instagram post {$post['id']}: {$mediaUrl}");
                                        continue;
                                    }
                                } catch (\Exception $e) {
                                    // Don't skip completely, the URL might work later
                                    Log::warning("Could not validate media URL: {$e->getMessage()}");
                                }
                                
                                // Check if post exists already
                                $existingPost = InstagramApiPost::where('instagram_id', $post['id'])->first();
                                
                                if (!$existingPost) {
                                    // Create new post
                                    InstagramApiPost::create([
                                        'instagram_id' => $post['id'],
                                        'title' => substr($caption, 0, 100),
                                        'caption' => $caption,
                                        'media_url' => $mediaUrl,
                                        'permalink' => $post['permalink'],
                                        'posted_at' => $post['timestamp'],
                                        'is_active' => true,
                                        'last_verified' => now()
                                    ]);
                                    
                                    $addedCount++;
                                } else {
                                    // Update existing post (URLs might change)
                                    $existingPost->update([
                                        'media_url' => $mediaUrl, 
                                        'caption' => $caption,
                                        'last_verified' => now()
                                    ]);
                                    
                                    $updatedCount++;
                                }
                            }
                        }
                        
                        // Cache the response for fallback
                        $this->cacheResponseToFile($data);
                        
                        return [
                            'success' => true, 
                            'message' => "Instagram posts fetched successfully. Added {$addedCount} new posts, updated {$updatedCount} existing posts."
                        ];
                    }
                }
            
                Log::warning('Instagram fetch attempt '.($attempt + 1).' failed: Invalid or empty response');
                $attempt++;
                
                if ($attempt < $retryCount) {
                    sleep(2); // Wait before retrying
                }
                
            } catch (\Exception $e) {
                Log::error('Instagram fetch attempt '.($attempt + 1).' failed: ' . $e->getMessage());
                $attempt++;
                
                if ($attempt >= $retryCount) {
                    // Try using cached data as last resort
                    if ($this->tryUsingCachedResponse()) {
                        return [
                            'success' => true, 
                            'message' => 'Used cached Instagram data after live fetch failed'
                        ];
                    }
                    
                    // If all else fails, create mock posts to ensure frontend always has content
                    $this->createMockInstagramPosts();
                    
                    return [
                        'success' => false, 
                        'message' => 'Error fetching Instagram posts: ' . $e->getMessage() . '. Created mock posts as fallback.'
                    ];
                }
                
                sleep(2); // Wait before retrying
            }
        }
        
        // If we get here, all attempts failed
        $this->createMockInstagramPosts();
        return ['success' => false, 'message' => 'Failed to fetch Instagram posts. Created mock posts as fallback.'];
    }
    
    /**
     * Cache Instagram API response to file for fallback
     * @param array $data API response data
     * @return bool Success status
     */
    private function cacheResponseToFile($data)
    {
        try {
            $cachePath = storage_path('app/instagram-cache');
            
            if (!File::exists($cachePath)) {
                File::makeDirectory($cachePath, 0755, true);
            }
            
            File::put(
                $cachePath . '/instagram_data.json',
                json_encode($data)
            );
            
            Log::info('Instagram data cached successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to cache Instagram data: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Try to use cached response if live API fetch fails
     * @return bool Success status
     */
    private function tryUsingCachedResponse()
    {
        try {
            $cachePath = storage_path('app/instagram-cache/instagram_data.json');
            
            if (File::exists($cachePath)) {
                $data = json_decode(File::get($cachePath), true);
                
                if (isset($data['data']) && is_array($data['data'])) {
                    $addedCount = 0;
                    
                    foreach ($data['data'] as $post) {
                        // Only process IMAGE and CAROUSEL_ALBUM types
                        if (($post['media_type'] == 'IMAGE' || $post['media_type'] == 'CAROUSEL_ALBUM') && isset($post['media_url'])) {
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
                                    'is_active' => true,
                                    'last_verified' => now()
                                ]);
                                
                                $addedCount++;
                            }
                        }
                    }
                    
                    Log::info("Used cached Instagram data. Added {$addedCount} posts");
                    return true;
                }
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to use cached Instagram data: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create mock Instagram posts when real ones can't be fetched
     * @return bool Success status
     */
    private function createMockInstagramPosts()
    {
        try {
            // Check if we have any real posts or if mock posts already exist
            $hasRealPosts = InstagramApiPost::where('instagram_id', 'not like', 'mock_%')
                                         ->where('instagram_id', 'not like', 'fallback_%')
                                         ->exists();
            
            $hasMockPosts = InstagramApiPost::where('instagram_id', 'like', 'mock_%')->exists();
            
            // Only create mock posts if we don't have any real posts or mock posts
            if (!$hasRealPosts && !$hasMockPosts) {
                $mockPosts = [
                    [
                        'instagram_id' => 'mock_1',
                        'title' => 'Kegiatan Mahasiswa UNJ',
                        'caption' => 'Mahasiswa UNJ meraih prestasi dalam kompetisi nasional #UNJBerprestasi #CampusLife',
                        'media_url' => 'https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434',
                        'permalink' => 'https://www.instagram.com/dit.isipunj/',
                        'posted_at' => now()->subDays(1),
                        'is_active' => true,
                        'last_verified' => now()
                    ],
                    [
                        'instagram_id' => 'mock_2',
                        'title' => 'Seminar Online DITSIP UNJ',
                        'caption' => 'Seminar online tentang teknologi informasi bersama para pakar #SeminarOnline #DITSIPUNJ',
                        'media_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png',
                        'permalink' => 'https://www.instagram.com/dit.isipunj/',
                        'posted_at' => now()->subDays(3),
                        'is_active' => true,
                        'last_verified' => now()
                    ],
                    [
                        'instagram_id' => 'mock_3',
                        'title' => 'Pemeringkatan Universitas',
                        'caption' => 'UNJ terus meningkatkan posisinya dalam pemeringkatan universitas nasional dan internasional #UNJMajuTerus',
                        'media_url' => 'https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434',
                        'permalink' => 'https://www.instagram.com/dit.isipunj/',
                        'posted_at' => now()->subDays(5),
                        'is_active' => true,
                        'last_verified' => now()
                    ],
                    // Add more realistic mock posts
                    [
                        'instagram_id' => 'mock_4',
                        'title' => 'Workshop Digital Marketing',
                        'caption' => 'Workshop Digital Marketing untuk mahasiswa UNJ. Belajar strategi pemasaran di era digital #DigitalMarketing #WorkshopUNJ',
                        'media_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png',
                        'permalink' => 'https://www.instagram.com/dit.isipunj/',
                        'posted_at' => now()->subDays(7),
                        'is_active' => true,
                        'last_verified' => now()
                    ],
                    [
                        'instagram_id' => 'mock_5',
                        'title' => 'UNJ Bersinergi',
                        'caption' => 'UNJ menjalin kerjasama dengan berbagai institusi untuk meningkatkan kualitas pendidikan #UNJBersinergi #Kolaborasi',
                        'media_url' => 'https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434',
                        'permalink' => 'https://www.instagram.com/dit.isipunj/',
                        'posted_at' => now()->subDays(9),
                        'is_active' => true,
                        'last_verified' => now()
                    ],
                    [
                        'instagram_id' => 'mock_6',
                        'title' => 'Pelatihan Sistem Informasi',
                        'caption' => 'Pelatihan penggunaan sistem informasi terbaru untuk civitas akademika UNJ #SistemInformasi #UNJ',
                        'media_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png',
                        'permalink' => 'https://www.instagram.com/dit.isipunj/',
                        'posted_at' => now()->subDays(11),
                        'is_active' => true,
                        'last_verified' => now()
                    ]
                ];
                
                foreach ($mockPosts as $post) {
                    InstagramApiPost::create($post);
                }
                
                Log::info('Created ' . count($mockPosts) . ' mock Instagram posts');
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error creating mock Instagram posts: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get basic fallback posts when everything else fails
     * @return array Array of basic post data
     */
    private function getBasicMockPosts()
    {
        return [
            [
                'instagram_id' => 'fallback_1',
                'title' => 'Kegiatan Mahasiswa UNJ',
                'caption' => 'Mahasiswa UNJ meraih prestasi dalam kompetisi nasional #UNJBerprestasi #CampusLife',
                'media_url' => 'https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434',
                'permalink' => 'https://www.instagram.com/dit.isipunj/',
                'posted_at' => now()->format('Y-m-d H:i:s'),
                'is_active' => true
            ],
            [
                'instagram_id' => 'fallback_2',
                'title' => 'Inovasi Teknologi UNJ',
                'caption' => 'Direktorat Inovasi, Sistem Informasi dan Pemeringkatan UNJ meluncurkan aplikasi baru untuk mahasiswa #InovasiUNJ',
                'media_url' => 'https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png',
                'permalink' => 'https://www.instagram.com/dit.isipunj/',
                'posted_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
                'is_active' => true
            ],
            [
                'instagram_id' => 'fallback_3',
                'title' => 'Pemeringkatan Universitas',
                'caption' => 'UNJ terus meningkatkan posisinya dalam pemeringkatan universitas nasional dan internasional #UNJMajuTerus',
                'media_url' => 'https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434',
                'permalink' => 'https://www.instagram.com/dit.isipunj/',
                'posted_at' => now()->subDays(4)->format('Y-m-d H:i:s'),
                'is_active' => true
            ]
        ];
    }
    
    /**
     * Get posts for frontend display with improved error handling
     * @return JsonResponse
     */
    public function getPosts()
    {
        try {
            // Check for "stale" posts (posts not verified in the last 24 hours)
            $lastVerified = InstagramApiPost::max('last_verified');
            $needsRefresh = !$lastVerified || Carbon::parse($lastVerified)->diffInHours(now()) > 24;
            
            // First check if we have posts in the database
            $posts = InstagramApiPost::where('is_active', true)
                    ->orderBy('posted_at', 'desc')
                    ->take(6)
                    ->get();
            
            // If no posts or need refresh, try to fetch them
            if ($posts->isEmpty() || $needsRefresh) {
                $this->fetchAndStoreInstagramPosts();
                
                // Try to get posts again
                $posts = InstagramApiPost::where('is_active', true)
                        ->orderBy('posted_at', 'desc')
                        ->take(3)
                        ->get();
            }
            
            // If we still have no posts (for any reason), use basic fallbacks
            if ($posts->isEmpty()) {
                return response()->json($this->getBasicMockPosts());
            }
            
            return response()->json($posts);
        } catch (\Exception $e) {
            Log::error('Error getting Instagram posts: ' . $e->getMessage());
            
            // Always return something, even if it's just fallback data
            return response()->json($this->getBasicMockPosts());
        }
    }
    
    /**
     * Manually trigger Instagram fetch (admin only)
     * @param Request $request
     * @return redirect
     */
    public function manualFetch(Request $request)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        $result = $this->fetchAndStoreInstagramPosts(3);
        
        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
    
    /**
     * Clear mock posts (admin only)
     * @param Request $request
     * @return redirect
     */
    public function clearMockPosts(Request $request)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        try {
            $count = InstagramApiPost::where('instagram_id', 'like', 'mock_%')
                                   ->orWhere('instagram_id', 'like', 'fallback_%')
                                   ->delete();
            return back()->with('success', "Cleared {$count} mock Instagram posts");
        } catch (\Exception $e) {
            Log::error('Error clearing mock posts: ' . $e->getMessage());
            return back()->with('error', 'Error clearing mock posts: ' . $e->getMessage());
        }
    }
    
    /**
     * Verify all media URLs and mark invalid ones
     * @param Request $request
     * @return redirect
     */
    public function verifyMediaUrls(Request $request)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        try {
            $posts = InstagramApiPost::where('is_active', true)->get();
            $invalidCount = 0;
            
            foreach ($posts as $post) {
                if ($post->media_url) {
                    try {
                        $check = Http::timeout(5)->head($post->media_url);
                        if (!$check->successful()) {
                            $post->update([
                                'is_active' => false,
                                'last_verified' => now()
                            ]);
                            $invalidCount++;
                        } else {
                            $post->update(['last_verified' => now()]);
                        }
                    } catch (\Exception $e) {
                        Log::warning("Could not verify media URL for post {$post->id}: {$e->getMessage()}");
                    }
                }
            }
            
            return back()->with('success', "Media URLs verified. Found {$invalidCount} invalid URLs.");
        } catch (\Exception $e) {
            Log::error('Error verifying media URLs: ' . $e->getMessage());
            return back()->with('error', 'Error verifying media URLs: ' . $e->getMessage());
        }
    }
}