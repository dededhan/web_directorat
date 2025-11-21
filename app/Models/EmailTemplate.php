<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'language',
        'subject',
        'greeting',
        'email_content',
        'button_text',
        'closing',
        'signature_name',
        'signature_title',
    ];

    /**
     * Get the email template for a specific category and language.
     *
     * @param string $category 'academic' or 'employee'
     * @param string $language 'en' or 'id'
     * @return EmailTemplate|null
     */
    public static function getTemplate(string $category, string $language = 'en'): ?EmailTemplate
    {
        return self::where('category', $category)
            ->where('language', $language)
            ->first();
    }

    /**
     * Replace placeholders in template text with actual values.
     *
     * @param string $text
     * @param array $data
     * @return string
     */
    public function replacePlaceholders(string $text, array $data): string
    {
        $placeholders = [
            '{title}' => $data['title'] ?? '',
            '{fullname}' => $data['fullname'] ?? '',
            '{surveyLink}' => $data['surveyLink'] ?? '#',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $text);
    }

    /**
     * Get category display name.
     *
     * @return string
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->category === 'academic' ? 'Academic' : 'Employee';
    }

    /**
     * Get language display name.
     *
     * @return string
     */
    public function getLanguageNameAttribute(): string
    {
        return $this->language === 'en' ? 'English' : 'Indonesian';
    }
}
