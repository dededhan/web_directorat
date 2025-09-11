<?php

namespace App\Exports;

use App\Models\RisetUnj;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class RisetSearchResultExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $search;
    protected $fakultas;
    protected $tahun;

    public function __construct($search, $fakultas, $tahun)
    {
        $this->search = $search;
        $this->fakultas = $fakultas;
        $this->tahun = $tahun;
    }

    public function query()
    {
        $query = RisetUnj::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('ketua_peneliti', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }

        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Ketua Peneliti',
            'Fakultas',
            'Tahun',
            'Skema',
            'Sumber Dana',
            'Dana Penelitian',
        ];
    }

    public function map($riset): array
    {
        return [
            $riset->judul,
            $riset->ketua_peneliti,
            $riset->fakultas,
            $riset->tahun,
            $riset->skema,
            $riset->sumber_dana,
            $riset->dana,
        ];
    }
}