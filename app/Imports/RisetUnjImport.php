<?php
// app/Imports/RisetUnjImport.php
namespace App\Imports;

use App\Models\RisetUnj;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RisetUnjImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['judul'])) {
            return null; // Melewati baris jika kolom JUDUL kosong
        }

       return new RisetUnj([
            'judul'           => $row['judul'],
            'ketua_peneliti'  => $row['ketua_peneliti'],
            'tahun'           => $row['tahun'],
            'fakultas'        => $row['fakultas'],
            'skema'           => $row['skema'],
            'bidang_ilmu'     => $row['bidang_ilmu'],
            'sumber_dana'     => $row['sumber_dana'],
            'dana'            => $row['dana_penelitian'],
        ]);
    }
}