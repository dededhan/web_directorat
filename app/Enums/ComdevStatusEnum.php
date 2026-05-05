<?php

namespace App\Enums;

enum ComdevStatusEnum: string
{
    case DRAFT = 'draft';
    case DIAJUKAN = 'diajukan';
    case MENUNGGU_DIREVIEW = 'menunggu_direview';
    case SEDANG_DIREVIEW = 'sedang_direview';
    case LOLOS_DIDANAI = 'lolos_didanai';
    case TIDAK_LOLOS_DIDANAI = 'tidak_lolos_didanai';
    case MENUNGGU_DI_ACC = 'menunggu_di_acc';
    case PERBAIKAN_DIPERLUKAN = 'perbaikan_diperlukan';
    case PROSES_TAHAP_SELANJUTNYA = 'proses_tahap_selanjutnya';
    case SELESAI = 'selesai';

    // Helper function untuk mendapatkan label yang rapi
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::DIAJUKAN => 'Diajukan',
            self::MENUNGGU_DIREVIEW => 'Menunggu Direview',
            self::SEDANG_DIREVIEW => 'Sedang Direview',
            self::LOLOS_DIDANAI => 'Lolos Didanai',
            self::TIDAK_LOLOS_DIDANAI => 'Tidak Lolos Didanai',
            self::MENUNGGU_DI_ACC => 'Menunggu Verifikasi Admin',
            self::PERBAIKAN_DIPERLUKAN => 'Perbaikan Diperlukan',
            self::PROSES_TAHAP_SELANJUTNYA => 'Proses Tahap Selanjutnya',
            self::SELESAI => 'Selesai',
        };
    }
}