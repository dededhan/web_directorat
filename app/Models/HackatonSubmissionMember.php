<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonSubmissionMember extends Model
{
    use HasFactory;

    protected $table = 'hackaton_submission_members';

    protected $guarded = ['id'];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /* ── Peran IC constants (Hacker / Hustler / Hipster) ─────── */
    public const PERAN_IC_OPTIONS = ['Hacker', 'Hustler', 'Hipster'];

    /* ── Tipe anggota constants ──────────────────────────────── */
    public const TIPE_DOSEN     = 'dosen';
    public const TIPE_ALUMNI    = 'alumni';
    public const TIPE_DUDI      = 'DUDI';
    public const TIPE_MAHASISWA = 'mahasiswa';
    public const TIPE_PPPK      = 'PPPK';
    public const TIPE_PENELITI  = 'peneliti';
    public const TIPE_TENDIK    = 'tendik';

    public const TIPE_OPTIONS = [
        self::TIPE_DOSEN,
        self::TIPE_ALUMNI,
        self::TIPE_DUDI,
        self::TIPE_MAHASISWA,
        self::TIPE_PPPK,
        self::TIPE_PENELITI,
        self::TIPE_TENDIK,
    ];

    public const TIPE_NEEDS_APPROVAL = [
        self::TIPE_DOSEN,
        self::TIPE_ALUMNI,
        self::TIPE_DUDI,
        self::TIPE_MAHASISWA,
        self::TIPE_PPPK,
        self::TIPE_PENELITI,
        self::TIPE_TENDIK,
    ];

    public const TIPE_SEARCHABLE = [
        self::TIPE_DOSEN,
        self::TIPE_ALUMNI,
        self::TIPE_MAHASISWA,
        self::TIPE_PPPK,
        self::TIPE_PENELITI,
        self::TIPE_DUDI,
        self::TIPE_TENDIK,
    ];

    /**
     * Map member tipe to user role in Hackaton.
     */
    public const TIPE_TO_ROLE = [
        'dosen'     => 'hackaton_dosen',
        'tendik'    => 'hackaton_tendik',
        'alumni'    => 'hackaton_alumni',
        'peneliti'  => 'hackaton_peneliti',
        'DUDI'      => 'hackaton_dudi',
        'PPPK'      => 'hackaton_pppk',
        'mahasiswa' => 'hackaton_mahasiswa',
    ];

    public function submission()
    {
        return $this->belongsTo(HackatonSubmission::class, 'hackaton_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function needsApproval(): bool
    {
        return in_array($this->tipe_anggota, self::TIPE_NEEDS_APPROVAL)
            && $this->approval_status === 'pending';
    }

    public function requiresApproval(): bool
    {
        return in_array($this->tipe_anggota, self::TIPE_NEEDS_APPROVAL);
    }

    public static function defaultApprovalStatus(string $tipe): string
    {
        return in_array($tipe, self::TIPE_NEEDS_APPROVAL) ? 'pending' : 'not_required';
    }

    public function getTipeLabel(): string
    {
        return match ($this->tipe_anggota) {
            'dosen'     => 'Dosen',
            'alumni'    => 'Alumni',
            'DUDI'      => 'DUDI',
            'mahasiswa' => 'Mahasiswa',
            'PPPK'      => 'PPPK',
            'peneliti'  => 'Peneliti',
            'tendik'    => 'Tendik',
            default     => ucfirst($this->tipe_anggota),
        };
    }

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
