<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternationalLecturerEmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'body',
        'include_consent_button',
        'button_text',
        'is_system',
        'created_by_name',
        'created_by_email',
    ];

    protected $casts = [
        'include_consent_button' => 'boolean',
        'is_system' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope template yang dapat diakses oleh user tertentu:
     * - Template milik user itu sendiri (user_id = $userId)
     * - ATAU template global/sistem (is_system = true)
     */
    public function scopeAccessibleFor($query, ?int $userId)
    {
        return $query->where(function ($q) use ($userId) {
            if ($userId) {
                $q->where('user_id', $userId);
            }
            $q->orWhere('is_system', true);
        });
    }

    /**
     * Render placeholders pada template dengan data dosen.
     */
    public function renderBody(DosenInternasional $lecturer, ?string $consentLink, bool $html = true): string
    {
        return InternationalLecturerCustomMail::renderPlaceholders($this->body, $lecturer, $consentLink, $html);
    }

    public function renderSubject(DosenInternasional $lecturer, ?string $consentLink): string
    {
        return InternationalLecturerCustomMail::renderPlaceholders($this->subject, $lecturer, $consentLink, false);
    }
}
