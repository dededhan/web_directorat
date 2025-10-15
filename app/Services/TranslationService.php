<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translator;
    protected $sourceLanguage = 'id'; // Indonesian
    protected $targetLanguage = 'en'; // English
    
    public function __construct()
    {
        try {
            $this->translator = new GoogleTranslate();
            $this->translator->setSource($this->sourceLanguage);
            $this->translator->setTarget($this->targetLanguage);
        } catch (\Exception $e) {
            Log::error('Translation service initialization failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Translate text from Indonesian to English
     * 
     * @param string $text
     * @param bool $useCache
     * @return string|null
     */
    public function translate(?string $text, bool $useCache = true): ?string
    {
        // Return null if text is empty
        if (empty($text)) {
            return null;
        }
        
        // Create a cache key based on the text
        $cacheKey = 'translation_' . md5($text);
        
        // Try to get from cache first if enabled
        if ($useCache && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        try {
            $translated = $this->translator->translate($text);
            
            // Cache the translation for 30 days
            if ($useCache) {
                Cache::put($cacheKey, $translated, now()->addDays(30));
            }
            
            return $translated;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => substr($text, 0, 100) // Log first 100 chars only
            ]);
            
            // Return original text if translation fails
            return $text;
        }
    }
    
    /**
     * Translate multiple texts at once
     * 
     * @param array $texts
     * @param bool $useCache
     * @return array
     */
    public function translateBatch(array $texts, bool $useCache = true): array
    {
        $translations = [];
        
        foreach ($texts as $key => $text) {
            $translations[$key] = $this->translate($text, $useCache);
        }
        
        return $translations;
    }
    
    /**
     * Strip HTML tags before translation to avoid issues
     * 
     * @param string $html
     * @param bool $useCache
     * @return string|null
     */
    public function translateHtml(?string $html, bool $useCache = true): ?string
    {
        if (empty($html)) {
            return null;
        }
        
        // Simple approach: translate the plain text content
        $plainText = strip_tags($html);
        return $this->translate($plainText, $useCache);
    }
}
