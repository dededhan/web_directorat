<?php


namespace App\Exports;


use App\Models\Responden;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;


class RespondenExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $kategori;
    protected $fakultas;


    public function __construct($kategori = null, $fakultas = null)
    {
        $this->kategori = $kategori;
        $this->fakultas = $fakultas;
    }
 
    public function query()
    {
        $query = Responden::query();


        if ($this->kategori) {
            $query->where('category', $this->kategori);
        }


        if ($this->fakultas) {
            $query->where('fakultas', $this->fakultas);
        }


        return $query;
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'title',
            'fullname',
            'jabatan',
            'instansi',
            'email',
            'phone_responden',
            'nama_dosen_pengusul',
            'phone_dosen',
            'fakultas',
            'category',
            'status'
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
            $this->getStatusText($row->status) // Use helper method here
        ];
    }
    private function getStatusText($status)
    {
        $status = $status ?? 'belum'; // Default to 'belum' if status is null
        $mapping = [
            'belum' => 'Belum di-email',
            'done' => 'Sudah di-email, belum di-follow up',
            'dones' => 'Sudah di-email, sudah di-follow up',
            'clear' => 'selesai',
        ];
        return $mapping[$status] ?? 'Belum di-email'; // Fallback if status unknown
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}


