<?php

namespace App\Enums;

enum InovChalengeStatusEnum: string
{
    case DRAFT                    = 'draft';
    case DIAJUKAN                 = 'diajukan';
    case MENUNGGU_DIREVIEW        = 'menunggu_direview';
    case SEDANG_DIREVIEW          = 'sedang_direview';
    case PERBAIKAN_DIPERLUKAN     = 'perbaikan_diperlukan';
    case PROSES_TAHAP_SELANJUTNYA = 'proses_tahap_selanjutnya';
    case SELESAI                  = 'selesai';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT                    => 'Draft',
            self::DIAJUKAN                 => 'Diajukan',
            self::MENUNGGU_DIREVIEW        => 'Menunggu Direview',
            self::SEDANG_DIREVIEW          => 'Sedang Direview',
            self::PERBAIKAN_DIPERLUKAN     => 'Perbaikan Diperlukan',
            self::PROSES_TAHAP_SELANJUTNYA => 'Proses Tahap Selanjutnya',
            self::SELESAI                  => 'Selesai',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::DRAFT                    => 'badge-secondary',
            self::DIAJUKAN                 => 'badge-info',
            self::MENUNGGU_DIREVIEW        => 'badge-warning',
            self::SEDANG_DIREVIEW          => 'badge-primary',
            self::PERBAIKAN_DIPERLUKAN     => 'badge-danger',
            self::PROSES_TAHAP_SELANJUTNYA => 'badge-success',
            self::SELESAI                  => 'badge-dark',
        };
    }

    public function isDosenEditable(): bool
    {
        return in_array($this, [self::DRAFT, self::PERBAIKAN_DIPERLUKAN]);
    }
}
