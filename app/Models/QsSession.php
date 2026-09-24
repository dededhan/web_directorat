<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QsSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mode',
        'description',
        'custom_fields_schema',
        'academic_form_schema',
        'employee_form_schema',
        'status',
        'start_date',
        'end_date',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'custom_fields_schema' => 'array',
        'academic_form_schema' => 'array',
        'employee_form_schema' => 'array',
    ];

    /**
     * Check if session uses form-based mode.
     */
    public function isFormBased(): bool
    {
        return $this->mode === 'form_based';
    }

    /**
     * Get the custom fields schema as an array.
     */
    public function getCustomFieldsSchema(): array
    {
        return is_array($this->custom_fields_schema) ? $this->custom_fields_schema : [];
    }

    /**
     * Get form schema for a specific category.
     */
    public function getFormSchema(string $category): array
    {
        $schema = ($category === 'academic') ? $this->academic_form_schema : $this->employee_form_schema;
        return is_array($schema) ? $schema : $this->getDefaultFormSchema($category);
    }

    /**
     * Get default form schema for category.
     */
    public function getDefaultFormSchema(string $category): array
    {
        if ($category === 'academic') {
            return [
                'standard_fields' => [
                    'title' => ['enabled' => true, 'required' => false],
                    'job_title' => ['enabled' => true, 'required' => true],
                    'institution' => ['enabled' => true, 'required' => true],
                    'department' => ['enabled' => true, 'required' => true],
                    'country' => ['enabled' => true, 'required' => true],
                    'phone' => ['enabled' => true, 'required' => false],
                ],
                'custom_questions' => [],
            ];
        }

        return [
            'standard_fields' => [
                'title' => ['enabled' => true, 'required' => false],
                'company_name' => ['enabled' => true, 'required' => true],
                'job_title' => ['enabled' => true, 'required' => true],
                'department' => ['enabled' => true, 'required' => false],
                'country' => ['enabled' => true, 'required' => true],
                'phone' => ['enabled' => true, 'required' => false],
            ],
            'custom_questions' => [],
        ];
    }

    /**
     * Session respondent pivot records.
     */
    public function sessionRespondents()
    {
        return $this->hasMany(QsSessionRespondent::class, 'qs_session_id');
    }

    /**
     * Bank respondents assigned to this session.
     */
    public function respondents()
    {
        return $this->belongsToMany(RespondenBank::class, 'qs_session_respondents', 'qs_session_id', 'responden_bank_id')
            ->withPivot(['category', 'email_sent_at', 'email_count', 'consent_status', 'consented_at', 'token'])
            ->withTimestamps();
    }

    /**
     * The admin who created this session.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Consent attempt logs for this session.
     */
    public function consentAttemptLogs()
    {
        return $this->hasMany(ConsentAttemptLog::class, 'qs_session_id');
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // --- Computed Attributes ---

    public function getTotalCountAttribute(): int
    {
        if (array_key_exists('session_respondents_count', $this->attributes)) {
            return (int) $this->attributes['session_respondents_count'];
        }
        if (array_key_exists('total_count', $this->attributes)) {
            return (int) $this->attributes['total_count'];
        }

        $accessibleIds = auth()->check() ? auth()->user()->getAccessibleUserIds() : null;
        $q = $this->sessionRespondents();
        if ($accessibleIds !== null) {
            $q->whereIn('added_by', $accessibleIds);
        }
        return $q->count();
    }

    public function getAgreedCountAttribute(): int
    {
        if (array_key_exists('agreed_count', $this->attributes)) {
            return (int) $this->attributes['agreed_count'];
        }

        $accessibleIds = auth()->check() ? auth()->user()->getAccessibleUserIds() : null;
        $q = $this->sessionRespondents()->where('consent_status', 'agreed');
        if ($accessibleIds !== null) {
            $q->whereIn('added_by', $accessibleIds);
        }
        return $q->count();
    }

    public function getPendingCountAttribute(): int
    {
        if (array_key_exists('pending_count', $this->attributes)) {
            return (int) $this->attributes['pending_count'];
        }

        $accessibleIds = auth()->check() ? auth()->user()->getAccessibleUserIds() : null;
        $q = $this->sessionRespondents()->where('consent_status', 'pending');
        if ($accessibleIds !== null) {
            $q->whereIn('added_by', $accessibleIds);
        }
        return $q->count();
    }

    public function getEmailSentCountAttribute(): int
    {
        if (array_key_exists('emailed_count', $this->attributes)) {
            return (int) $this->attributes['emailed_count'];
        }
        if (array_key_exists('email_sent_count', $this->attributes)) {
            return (int) $this->attributes['email_sent_count'];
        }

        $accessibleIds = auth()->check() ? auth()->user()->getAccessibleUserIds() : null;
        $q = $this->sessionRespondents()->whereNotNull('email_sent_at');
        if ($accessibleIds !== null) {
            $q->whereIn('added_by', $accessibleIds);
        }
        return $q->count();
    }

    public function getNotEmailedCountAttribute(): int
    {
        if (array_key_exists('not_emailed_count', $this->attributes)) {
            return (int) $this->attributes['not_emailed_count'];
        }

        $accessibleIds = auth()->check() ? auth()->user()->getAccessibleUserIds() : null;
        $q = $this->sessionRespondents()->whereNull('email_sent_at');
        if ($accessibleIds !== null) {
            $q->whereIn('added_by', $accessibleIds);
        }
        return $q->count();
    }

    public function getConsentRateAttribute(): float
    {
        $total = $this->total_count;
        $agreed = $this->agreed_count;
        return $total > 0 ? round(($agreed / $total) * 100, 1) : 0.0;
    }

    /**
     * Check if session has expired based on end_date.
     */
    public function isExpired(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }
}
