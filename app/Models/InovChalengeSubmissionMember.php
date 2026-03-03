<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeSubmissionMember extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /* ── Tipe anggota constants ──────────────────────────────── */
    public const TIPE_DOSEN     = 'dosen';
    public const TIPE_ALUMNI    = 'alumni';
    public const TIPE_DUDI      = 'DUDI';
    public const TIPE_MAHASISWA = 'mahasiswa';
    public const TIPE_PPPK      = 'PPPK';
    public const TIPE_PENELITI  = 'peneliti';

    public const TIPE_OPTIONS = [
        self::TIPE_DOSEN,
        self::TIPE_ALUMNI,
        self::TIPE_DUDI,
        self::TIPE_MAHASISWA,
        self::TIPE_PPPK,
        self::TIPE_PENELITI,
    ];

    /** Types that require approval from the invited member. */
    public const TIPE_NEEDS_APPROVAL = [
        self::TIPE_ALUMNI,
        self::TIPE_DUDI,
        self::TIPE_MAHASISWA,
        self::TIPE_PPPK,
        self::TIPE_PENELITI,
    ];

    /**
     * Types that can be searched in the users table.
     * All registered role types have system accounts.
     */
    public const TIPE_SEARCHABLE = [
        self::TIPE_DOSEN,
        self::TIPE_ALUMNI,
        self::TIPE_MAHASISWA,
        self::TIPE_PPPK,
        self::TIPE_PENELITI,
        self::TIPE_DUDI,
    ];

    /**
     * Map member tipe to user role (handles case differences).
     */
    public const TIPE_TO_ROLE = [
        'DUDI' => 'dudi',
        'PPPK' => 'pppk',
    ];

    /* ── Relationships ───────────────────────────────────────── */
    public function submission()
    {
        return $this->belongsTo(InovChalengeSubmission::class, 'inov_chalenge_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* ── Approval helpers ────────────────────────────────────── */

    /**
     * Whether this member still needs approval.
     */
    public function needsApproval(): bool
    {
        return in_array($this->tipe_anggota, self::TIPE_NEEDS_APPROVAL)
            && $this->approval_status === 'pending';
    }

    /**
     * Whether approval is required for this member type.
     */
    public function requiresApproval(): bool
    {
        return in_array($this->tipe_anggota, self::TIPE_NEEDS_APPROVAL);
    }

    /**
     * Determine the approval status for new members based on type.
     */
    public static function defaultApprovalStatus(string $tipe): string
    {
        return in_array($tipe, self::TIPE_NEEDS_APPROVAL) ? 'pending' : 'not_required';
    }

    /**
     * Get display label for the type.
     */
    public function getTipeLabel(): string
    {
        return match ($this->tipe_anggota) {
            'dosen'     => 'Dosen',
            'alumni'    => 'Alumni',
            'DUDI'      => 'DUDI',
            'mahasiswa' => 'Mahasiswa',
            'PPPK'      => 'PPPK',
            'peneliti'  => 'Peneliti',
            default     => ucfirst($this->tipe_anggota),
        };
    }

    /**
     * Get approval status display info (label, color, icon).
     */
    public function getApprovalBadge(): array
    {
        return match ($this->approval_status) {
            'not_required' => [
                'label' => 'Approved',
                'color' => 'bg-green-100 text-green-700',
                'icon'  => 'fas fa-check-circle',
            ],
            'pending' => [
                'label' => 'Menunggu Persetujuan',
                'color' => 'bg-yellow-100 text-yellow-700',
                'icon'  => 'fas fa-clock',
            ],
            'approved' => [
                'label' => 'Disetujui',
                'color' => 'bg-green-100 text-green-700',
                'icon'  => 'fas fa-check-circle',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'color' => 'bg-red-100 text-red-700',
                'icon'  => 'fas fa-times-circle',
            ],
            default => [
                'label' => ucfirst($this->approval_status),
                'color' => 'bg-gray-100 text-gray-600',
                'icon'  => 'fas fa-question-circle',
            ],
        };
    }
}
