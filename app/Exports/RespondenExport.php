<?php

namespace App\Exports;

use App\Models\Responden;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RespondenExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $user;
    protected $kategori;
    protected $fakultas;
    protected $startDate;
    protected $endDate;

    public function __construct(User $user, $kategori = null, $fakultas = null, $startDate = null, $endDate = null)
    {
        $this->user = $user;
        $this->kategori = $kategori;
        $this->fakultas = $fakultas;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = Responden::query()->with('user');

        $role = $this->user->role;
        if ($role === 'prodi') {
             $query->where('user_id', $this->user->id);
        } elseif ($role === 'fakultas') {
            $facultyCode = strtolower($this->user->name);
            $prodiUserIds = User::where('role', 'prodi')
                ->where('name', 'like', $facultyCode . '-%')
                ->pluck('id');
            $allUserIds = $prodiUserIds->push($this->user->id)->all();
            $query->whereIn('user_id', $allUserIds);
        }

        if ($this->kategori) {
            $query->where('category', $this->kategori);
        }

        if ($this->fakultas) {
            $query->whereRaw('LOWER(TRIM(fakultas)) = ?', [strtolower(trim($this->fakultas))]);
        }

        if ($this->startDate && $this->endDate) {
            try {
                $start = Carbon::parse($this->startDate)->startOfDay();
                $end = Carbon::parse($this->endDate)->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            } catch (\Exception $e) {
            }
        }

        // Add default ordering
        $query->orderBy('created_at', 'desc');

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'User ID (Inputter)',
            'Tanggal Dibuat',
            'Title',
            'Fullname',
            'Jabatan',
            'Instansi',
            'Email',
            'Phone Responden',
            'Nama Dosen Pengusul',
            'Phone Dosen',
            'Fakultas',
            'Category',
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
            $row->user->name ?? 'N/A',
            $row->created_at ? $row->created_at->format('d-m-Y H:i:s') : 'N/A',
            Str::ucfirst($row->title),
            $row->fullname,
            $row->jabatan,
            $row->instansi,
            $row->email,
            $row->phone_responden,
            $row->nama_dosen_pengusul,
            $row->phone_dosen,
            strtoupper($row->fakultas),
            $row->category,
            $this->getStatusText($row->status)
        ];
    }

    private function getStatusText($status)
    {
        $status = $status ?? 'belum';
        $mapping = [
            'belum' => 'Belum di-email',
            'done' => 'Sudah di-email, belum di-follow up',
            'dones' => 'Sudah di-email, sudah di-follow up',
            'clear' => 'Selesai',
        ];
        return $mapping[$status] ?? 'Belum di-email';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
