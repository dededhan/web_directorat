<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QsSessionRespondent extends Model
{
    use HasFactory;

    protected $fillable = [
        'qs_session_id',
        'responden_bank_id',
        'category',
        'custom_fields',
        'form_answers',
        'form_submitted_at',
        'email_sent_at',
        'email_count',
        'consent_status',
        'consented_at',
        'consent_ip',
        'token',
        'added_by',
    ];

    protected $casts = [
        'email_sent_at' => 'datetime',
        'consented_at' => 'datetime',
        'form_submitted_at' => 'datetime',
        'custom_fields' => 'array',
        'form_answers' => 'array',
    ];

    /**
     * Check if this respondent has submitted questionnaire form.
     */
    public function hasSubmittedForm(): bool
    {
        return !empty($this->form_submitted_at) || (!empty($this->form_answers) && is_array($this->form_answers) && count($this->form_answers) > 0);
    }

    /**
     * Check if this respondent has answered or given consent.
     */
    public function hasAnswered(): bool
    {
        return $this->consent_status === 'agreed' || $this->hasSubmittedForm();
    }

    /**
     * Get a specific custom field value.
     */
    public function getCustomFieldValue(string $key, $default = null)
    {
        return $this->custom_fields[$key] ?? $default;
    }

    /**
     * Get a specific form answer value.
     */
    public function getFormAnswer(string $key, $default = null)
    {
        return $this->form_answers[$key] ?? $default;
    }

    /**
     * The session this pivot belongs to.
     */
    public function session()
    {
        return $this->belongsTo(QsSession::class, 'qs_session_id');
    }

    /**
     * The bank respondent this pivot belongs to.
     */
    public function bankRespondent()
    {
        return $this->belongsTo(RespondenBank::class, 'responden_bank_id');
    }

    /**
     * The user who added this respondent to the session.
     */
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Get the display label for the user / unit who added this respondent.
     * a. If admin pemeringkatan / direktorat -> 'Direktorat'
     * b. If fakultas -> 'Fakultas - [Nama Fakultas]'
     * c. If prodi -> '[Nama Prodi]'
     */
    public function getAddedByLabelAttribute(): string
    {
        $user = $this->addedByUser ?? $this->bankRespondent?->sourceUser ?? $this->session?->creator;
        if (!$user) {
            return 'Direktorat';
        }

        $role = $user->role ?? '';

        if (in_array($role, ['admin_pemeringkatan', 'admin_direktorat', 'super_admin', 'kepala_direktorat', 'kepala_sub_direktorat', 'wr3', 'admin_hilirisasi', 'admin_inovasi'])) {
            return 'Direktorat';
        }

        if (in_array($role, ['fakultas', 'equity_fakultas'])) {
            $fakName = $user->fakultas?->name ?? $user->profile?->fakultas?->name ?? $user->profile?->fakultas?->abbreviation ?? $user->name;
            if (!empty($fakName)) {
                return str_starts_with(strtoupper($fakName), 'FAKULTAS') ? $fakName : 'Fakultas - ' . $fakName;
            }
            return 'Fakultas';
        }

        if ($role === 'prodi') {
            $prodiName = $user->prodiDirect?->name ?? $user->profile?->prodi?->name ?? $user->name;
            return $prodiName ?: 'Prodi';
        }

        return $user->name ?: 'Direktorat';
    }
}

