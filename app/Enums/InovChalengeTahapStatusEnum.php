<?php

namespace App\Enums;

/**
 * Status for each submission's Tahap (inov_chalenge_submission_tahap.status)
 */
enum InovChalengeTahapStatusEnum: string
{
    case BELUM_DIISI = 'belum_diisi'; // Not yet started
    case DRAFT       = 'draft';       // Saved as draft, not submitted
    case DIAJUKAN    = 'diajukan';    // Submitted to admin

    public function label(): string
    {
        return match ($this) {
            self::BELUM_DIISI => 'Belum Diisi',
            self::DRAFT       => 'Draft',
            self::DIAJUKAN    => 'Diajukan',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::BELUM_DIISI => 'badge-secondary',
            self::DRAFT       => 'badge-warning',
            self::DIAJUKAN    => 'badge-success',
        };
    }

    public function isEditable(): bool
    {
        return in_array($this, [self::BELUM_DIISI, self::DRAFT]);
    }
}

/**
 * Admin review status for each Tahap (inov_chalenge_submission_tahap.admin_status)
 */
enum InovChalengeTahapAdminStatusEnum: string
{
    case MENUNGGU  = 'menunggu';  // Newly submitted, not yet processed
    case DISETUJUI = 'disetujui'; // Admin approved this Tahap
    case PERBAIKAN = 'perbaikan'; // Admin requests revision (unlocks Tahap for dosen)
    case SELESAI   = 'selesai';   // Tahap finalized

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU  => 'Menunggu',
            self::DISETUJUI => 'Disetujui',
            self::PERBAIKAN => 'Perlu Perbaikan',
            self::SELESAI   => 'Selesai',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::MENUNGGU  => 'badge-warning',
            self::DISETUJUI => 'badge-info',
            self::PERBAIKAN => 'badge-danger',
            self::SELESAI   => 'badge-success',
        };
    }

    /** When admin sets this status, dosen can re-edit the Tahap */
    public function unlocksTahap(): bool
    {
        return $this === self::PERBAIKAN;
    }
}
