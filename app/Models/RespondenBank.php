<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondenBank extends Model
{
    use HasFactory;

    protected $table = 'responden_bank';

    protected $fillable = [
        'email',
        'title',
        'first_name',
        'last_name',
        'job_title',
        'institution',
        'department',
        'company_name',
        'position',
        'country',
        'phone',
        'category',
        'custom_fields',
        'source',
        'source_user_id',
    ];

    protected $casts = [
        'custom_fields' => 'array',
    ];

    /**
     * Session respondent pivot records for this bank entry.
     */
    public function sessionRespondents()
    {
        return $this->hasMany(QsSessionRespondent::class, 'responden_bank_id');
    }

    /**
     * Sessions this respondent is assigned to.
     */
    public function sessions()
    {
        return $this->belongsToMany(QsSession::class, 'qs_session_respondents', 'responden_bank_id', 'qs_session_id')
            ->withPivot(['category', 'email_sent_at', 'email_count', 'consent_status', 'consented_at', 'token'])
            ->withTimestamps();
    }

    /**
     * The user who originally added this respondent.
     */
    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    /**
     * Consent attempt logs for this respondent.
     */
    public function consentAttemptLogs()
    {
        return $this->hasMany(ConsentAttemptLog::class, 'responden_bank_id');
    }

    /**
     * Check if this email has ever agreed to any session globally.
     */
    public function hasEverConsented(): bool
    {
        return $this->sessionRespondents()
            ->where('consent_status', 'agreed')
            ->exists();
    }

    /**
     * Get the full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Normalize and set the category value.
     */
    public static function normalizeCategory(?string $category): ?string
    {
        if (empty($category)) {
            return null;
        }

        $value = strtolower(trim($category));
        $academic = ['academic', 'researcher', 'reseracher'];
        $employer = ['employer', 'employeer', 'industri', 'employee'];

        foreach ($academic as $k) {
            if (str_contains($value, $k)) return 'academic';
        }
        foreach ($employer as $k) {
            if (str_contains($value, $k)) return 'employee';
        }

        return null;
    }

    /**
     * Normalize a phone number to digits only, with Indonesian standard prefix '62'.
     */
    public static function normalizePhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        // Strip non-digit characters
        $digits = preg_replace('/[^\d]/', '', $phone);

        if (empty($digits)) {
            return null;
        }

        // Standardize Indonesian prefixes:
        // 08... -> 628...
        // 8... -> 628...
        if (str_starts_with($digits, '08')) {
            $digits = '628' . substr($digits, 2);
        } elseif (str_starts_with($digits, '8') && strlen($digits) >= 9) {
            $digits = '628' . substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Check duplicate status for adding/importing a respondent into a QS session.
     * 
     * Rules:
     * 1. Blocked if email/phone already in THIS session.
     * 2. Blocked if email/phone has already answered (in Responden Bank legacy or agreed in any session).
     * 3. Allowed if in another session but still pending (not yet approved/agreed).
     * 4. Allowed if completely fresh.
     */
    public static function checkDuplicateStatus(int $currentSessionId, string $email, ?string $phone = null): array
    {
        $cleanEmail = strtolower(trim($email));
        $normPhone = self::normalizePhone($phone);

        // 1. Check if email already in THIS session
        $inCurrentSessionByEmail = QsSessionRespondent::where('qs_session_id', $currentSessionId)
            ->whereHas('bankRespondent', function ($q) use ($cleanEmail) {
                $q->where('email', $cleanEmail);
            })->exists();

        if ($inCurrentSessionByEmail) {
            return [
                'allowed' => false,
                'status' => 'already_in_session',
                'field' => 'email',
                'message' => "Responden dengan email '{$cleanEmail}' sudah ada di sesi ini. Tidak dapat ditambahkan kembali.",
            ];
        }

        // 2. Check if phone already in THIS session (if provided)
        if (!empty($normPhone)) {
            $sessionRespondents = QsSessionRespondent::where('qs_session_id', $currentSessionId)
                ->whereHas('bankRespondent', function ($q) {
                    $q->whereNotNull('phone');
                })
                ->with('bankRespondent')
                ->get();

            foreach ($sessionRespondents as $sr) {
                if (self::normalizePhone($sr->bankRespondent->phone) === $normPhone) {
                    return [
                        'allowed' => false,
                        'status' => 'already_in_session',
                        'field' => 'phone',
                        'message' => "Responden dengan nomor telepon '{$phone}' sudah ada di sesi ini. Tidak dapat ditambahkan kembali.",
                    ];
                }
            }
        }

        // 3. Check if email ALREADY ANSWERED / in Responden Bank
        $bankByEmail = self::where('email', $cleanEmail)->first();
        if ($bankByEmail) {
            $hasAgreedSession = $bankByEmail->sessionRespondents()->where('consent_status', 'agreed')->exists();
            $isLegacyOrSubmitted = in_array($bankByEmail->source, ['legacy_migration', 'form_submission']);

            if ($hasAgreedSession || $isLegacyOrSubmitted) {
                return [
                    'allowed' => false,
                    'status' => 'already_answered',
                    'field' => 'email',
                    'message' => "Email '{$cleanEmail}' sudah terdaftar di Bank Responden (sudah mengisi kuesioner / memberikan persetujuan). Tidak dapat digunakan lagi.",
                ];
            }
        }

        // 4. Check if phone ALREADY ANSWERED / in Responden Bank (if provided)
        if (!empty($normPhone)) {
            $suffix = substr($normPhone, -8);
            $phoneCandidates = self::whereNotNull('phone')
                ->where('phone', 'like', "%{$suffix}%")
                ->get();

            foreach ($phoneCandidates as $candidate) {
                if (self::normalizePhone($candidate->phone) === $normPhone) {
                    $hasAgreed = $candidate->sessionRespondents()->where('consent_status', 'agreed')->exists();
                    $isLegacy = in_array($candidate->source, ['legacy_migration', 'form_submission']);

                    if ($hasAgreed || $isLegacy) {
                        return [
                            'allowed' => false,
                            'status' => 'already_answered',
                            'field' => 'phone',
                            'message' => "Nomor telepon '{$phone}' sudah terdaftar di Bank Responden (sudah mengisi kuesioner / memberikan persetujuan). Tidak dapat digunakan lagi.",
                        ];
                    }
                }
            }
        }

        // 5. Check if in ANOTHER session with pending status (Allowed!)
        if ($bankByEmail && $bankByEmail->sessionRespondents()->exists()) {
            $otherSessionNames = $bankByEmail->sessions()
                ->where('qs_sessions.id', '!=', $currentSessionId)
                ->pluck('name')
                ->toArray();

            $sessionList = !empty($otherSessionNames) ? implode(', ', $otherSessionNames) : 'sesi lain';

            return [
                'allowed' => true,
                'status' => 'pending_in_other_session',
                'field' => null,
                'message' => "Responden terdaftar di {$sessionList} namun belum memberikan persetujuan. Dapat ditambahkan ke sesi ini.",
                'bank_respondent' => $bankByEmail,
            ];
        }

        // 6. Completely new and available!
        return [
            'allowed' => true,
            'status' => 'ok',
            'field' => null,
            'message' => 'Email dan nomor telepon tersedia untuk ditambahkan.',
            'bank_respondent' => null,
        ];
    }
}
