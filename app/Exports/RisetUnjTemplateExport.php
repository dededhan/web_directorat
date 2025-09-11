<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RisetUnjTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
     * @return array
     */
    public function headings(): array
    {
        // Header yang akan dilihat admin di file Excel
        return [
            'JUDUL',
            'KETUA PENELITI',
            'TAHUN',
            'FAKULTAS',
            'SKEMA',
            'BIDANG ILMU',
            'SUMBER DANA',
            'DANA PENELITIAN',
        ];
    }

    /**
     * @return array
     */
    public function array(): array
    {
        // Baris contoh isian
        return [
            [
                'Contoh: Pengembangan Aplikasi Mobile Edukasi',
                'Contoh: Prof. Dr. Nama Dosen, M.Kom.',
                '2025',
                'FT',
                'Penelitian Terapan',
                'Ilmu Komputer',
                'Dana Internal UNJ',
                '50000000', // Hanya angka
            ],
        ];
    }
}