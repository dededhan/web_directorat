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
        
        // If no tags are present, just translate the text directly
        if ($html === strip_tags($html)) {
            return $this->translate($html, $useCache);
        }

        try {
            // Use DOMDocument to translate only text nodes while preserving tags
            $dom = new \DOMDocument();
            
            // Suppress errors for malformed HTML
            libxml_use_internal_errors(true);
            
            // Load HTML with a wrapper to handle fragments and ensure UTF-8
            // mb_convert_encoding to HTML-ENTITIES is a reliable way to load UTF-8 into DOMDocument
            $wrappedHtml = '<div>' . $html . '</div>';
            $dom->loadHTML(mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            $xpath = new \DOMXPath($dom);
            $textNodes = $xpath->query('//text()');
            
            foreach ($textNodes as $node) {
                $text = $node->nodeValue;
                // Only translate nodes that contain non-whitespace text
                if (trim($text) !== '') {
                    $node->nodeValue = $this->translate($text, $useCache);
                }
            }
            
            // Save the translated HTML and remove the wrapper <div>...</div>
            $translatedHtml = $dom->saveHTML($dom->documentElement);
            
            // Remove the <div> and </div> wrapper tags (first 5 and last 6 chars)
            if (strpos($translatedHtml, '<div>') === 0) {
                $translatedHtml = substr($translatedHtml, 5, -6);
            }
            
            libxml_clear_errors();
            return $translatedHtml;
            
        } catch (\Exception $e) {
            Log::warning('HTML translation failed, falling back to basic translation: ' . $e->getMessage());
            // Fallback: strip tags and translate as plain text to ensure something is returned
            return $this->translate(strip_tags($html), $useCache);
        }
    }
}
