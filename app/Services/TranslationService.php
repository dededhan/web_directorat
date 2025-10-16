<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translator;
    protected $sourceLanguage = 'id'; 
    protected $targetLanguage = 'en'; 
    
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
    

    public function translate(?string $text, bool $useCache = true): ?string
    {

        if (empty($text)) {
            return null;
        }
        

        $cacheKey = 'translation_' . md5($text);
        

        if ($useCache && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        
        try {
            $translated = $this->translator->translate($text);
            
     
            if ($useCache) {
                Cache::put($cacheKey, $translated, now()->addDays(30));
            }
            
            return $translated;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage(), [
                'text' => substr($text, 0, 100)
            ]);
            

            return $text;
        }
    }
    

    public function translateToEnglish(?string $text, bool $useCache = true): ?string
    {
        return $this->translate($text, $useCache);
    }
    

    public function translateBatch(array $texts, bool $useCache = true): array
    {
        $translations = [];
        
        foreach ($texts as $key => $text) {
            $translations[$key] = $this->translate($text, $useCache);
        }
        
        return $translations;
    }
    

    public function translateHtml(?string $html, string $targetLang = 'en', bool $useCache = true): ?string
    {
        if (empty($html)) {
            return null;
        }
        

        $plainText = strip_tags($html);
        return $this->translate($plainText, $useCache);
    }
}
