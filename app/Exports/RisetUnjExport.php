<?php
namespace App\Exports;

use App\Models\RisetUnj;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RisetUnjExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return RisetUnj::all();
    }

    public function headings(): array
{
    return [
        'Judul Riset',
        'Nama Ketua Peneliti',
        'Tahun Riset',
        'Fakultas Peneliti',
        'Skema',
        'Bidang Ilmu',
        'Sumber Dana', // <-- Kolom baru
        'Dana Penelitian', // <-- Nama diubah
    ];
}
}