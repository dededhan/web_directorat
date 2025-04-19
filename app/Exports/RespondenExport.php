<?php

namespace App\Exports;

use App\Models\Responden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;

class RespondenExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Responden::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Title',
            'Nama Lengkap',
            'Jabatan',
            'Instansi',
            'Email',
            'No. Responden',
            'Nama Dosen',
            'No. Narahubung',
            'Fakultas',
            'Kategori',
            'Status'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            Str::ucfirst($row->title),
            $row->fullname,
            $row->jabatan,
            $row->instansi,
            $row->email,
            $row->phone_responden,
            $row->nama_dosen_pengusul,
            $row->phone_dosen,
            $row->fakultas,
            $row->category,
            $row->status ?? 'belum'
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}