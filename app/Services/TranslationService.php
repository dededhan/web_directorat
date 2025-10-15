<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Translate text from Indonesian to English
     * 
     * @param string $text
     * @return string
     */
    public function translateToEnglish(string $text): string
    {
        try {
            // Set source and target languages
            $this->translator->setSource('id'); // Indonesian
            $this->translator->setTarget('en'); // English
            
            // Translate the text
            $translated = $this->translator->translate($text);
            
            return $translated;
        } catch (\Exception $e) {
            Log::error('Translation error: ' . $e->getMessage());
            // Return original text if translation fails
            return $text;
        }
    }

    /**
     * Translate text from English to Indonesian
     * 
     * @param string $text
     * @return string
     */
    public function translateToIndonesian(string $text): string
    {
        try {
            // Set source and target languages
            $this->translator->setSource('en'); // English
            $this->translator->setTarget('id'); // Indonesian
            
            // Translate the text
            $translated = $this->translator->translate($text);
            
            return $translated;
        } catch (\Exception $e) {
            Log::error('Translation error: ' . $e->getMessage());
            // Return original text if translation fails
            return $text;
        }
    }

    /**
     * Translate HTML content while preserving tags
     * This is useful for rich text content from CKEditor
     * 
     * @param string $html
     * @param string $targetLang 'en' or 'id'
     * @return string
     */
    public function translateHtml(string $html, string $targetLang = 'en'): string
    {
        try {
            // Extract text from HTML tags
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            // Get all text nodes
            $xpath = new \DOMXPath($dom);
            $textNodes = $xpath->query('//text()[normalize-space()]');
            
            // Set translation direction
            if ($targetLang === 'en') {
                $this->translator->setSource('id');
                $this->translator->setTarget('en');
            } else {
                $this->translator->setSource('en');
                $this->translator->setTarget('id');
            }
            
            // Translate each text node
            foreach ($textNodes as $node) {
                $originalText = trim($node->nodeValue);
                if (!empty($originalText)) {
                    $translatedText = $this->translator->translate($originalText);
                    $node->nodeValue = $translatedText;
                }
            }
            
            // Return the HTML with translated text
            return $dom->saveHTML();
        } catch (\Exception $e) {
            Log::error('HTML Translation error: ' . $e->getMessage());
            
            // Fallback: simple text translation without HTML parsing
            if ($targetLang === 'en') {
                return $this->translateToEnglish(strip_tags($html));
            } else {
                return $this->translateToIndonesian(strip_tags($html));
            }
        }
    }

    /**
     * Auto-detect language and translate accordingly
     * 
     * @param string $text
     * @param string $targetLang
     * @return string
     */
    public function autoTranslate(string $text, string $targetLang = 'en'): string
    {
        try {
            $this->translator->setTarget($targetLang);
            return $this->translator->translate($text);
        } catch (\Exception $e) {
            Log::error('Auto translation error: ' . $e->getMessage());
            return $text;
        }
    }
}
