<?php

namespace App\Exports;

use App\Models\DosenInternasional;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InternationalLecturerDataExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    use Exportable;

    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = DosenInternasional::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('negara', 'like', "%{$search}%")
                    ->orWhere('universitas_asal', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['sesi'])) {
            $query->where('sesi', $this->filters['sesi']);
        }

        if (!empty($this->filters['tahun'])) {
            $query->where('tahun', $this->filters['tahun']);
        }

        if (!empty($this->filters['fakultas'])) {
            $query->where('fakultas', $this->filters['fakultas']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['subject'])) {
            $subject = $this->filters['subject'];
            $query->where(function ($q) use ($subject) {
                $q->where('subject_1', $subject)
                    ->orWhere('subject_2', $subject);
            });
        }

        $isFilterBelumFix = (!empty($this->filters['email_status']) && $this->filters['email_status'] === 'email_belum_fix')
            || (!empty($this->filters['kelengkapan_data']) && $this->filters['kelengkapan_data'] === 'email_belum_fix')
            || (!empty($this->filters['category']) && $this->filters['category'] === 'email_belum_fix')
            || !empty($this->filters['email_belum_fix']);

        if ($isFilterBelumFix) {
            $invalidIds = DosenInternasional::query()
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get(['id', 'email'])
                ->reject(fn ($l) => \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email))
                ->pluck('id');

            $query->whereIn('id', $invalidIds);
        }

        if (!empty($this->filters['kelengkapan_data']) && $this->filters['kelengkapan_data'] !== 'email_belum_fix') {
            $kd = $this->filters['kelengkapan_data'];
            if ($kd === 'incomplete') {
                $query->where(function ($q) {
                    $q->whereNull('email')->orWhere('email', '')
                      ->orWhereNull('subject_1')->orWhere('subject_1', '')
                      ->orWhereNull('jenis_kelamin')->orWhere('jenis_kelamin', '')
                      ->orWhereNull('jabatan')->orWhere('jabatan', '')
                      ->orWhereNull('universitas_asal')->orWhere('universitas_asal', '')
                      ->orWhereNull('negara')->orWhere('negara', '');
                });
            } elseif ($kd === 'missing_email') {
                $query->where(function ($q) {
                    $q->whereNull('email')->orWhere('email', '');
                });
            } elseif ($kd === 'missing_subject') {
                $query->where(function ($q) {
                    $q->whereNull('subject_1')->orWhere('subject_1', '');
                });
            } elseif ($kd === 'missing_gender') {
                $query->where(function ($q) {
                    $q->whereNull('jenis_kelamin')->orWhere('jenis_kelamin', '');
                });
            } elseif ($kd === 'missing_jabatan') {
                $query->where(function ($q) {
                    $q->whereNull('jabatan')->orWhere('jabatan', '');
                });
            } elseif ($kd === 'missing_universitas') {
                $query->where(function ($q) {
                    $q->whereNull('universitas_asal')->orWhere('universitas_asal', '');
                });
            } elseif ($kd === 'missing_negara') {
                $query->where(function ($q) {
                    $q->whereNull('negara')->orWhere('negara', '');
                });
            } elseif ($kd === 'complete') {
                $query->whereNotNull('email')->where('email', '!=', '')
                      ->whereNotNull('subject_1')->where('subject_1', '!=', '')
                      ->whereNotNull('jenis_kelamin')->where('jenis_kelamin', '!=', '')
                      ->whereNotNull('jabatan')->where('jabatan', '!=', '')
                      ->whereNotNull('universitas_asal')->where('universitas_asal', '!=', '')
                      ->whereNotNull('negara')->where('negara', '!=', '');
            }
        }

        if (!empty($this->filters['email_status']) && $this->filters['email_status'] !== 'email_belum_fix') {
            if ($this->filters['email_status'] === 'sent') {
                $query->whereIn('email_status', ['sent', 'queued', 'sending']);
            } elseif ($this->filters['email_status'] === 'not_sent') {
                $query->where(function ($q) {
                    $q->whereNull('email_status')
                      ->orWhere('email_status', '')
                      ->orWhere('email_status', 'not_sent');
                });
            } else {
                $query->where('email_status', $this->filters['email_status']);
            }
        }

        return $query->latest('id');
    }

    public function headings(): array
    {
        return [
            'Nama Dosen Asing',
            'Jenis Kelamin',
            'Jabatan',
            'Institusi Asal',
            'Negara',
            'Email',
            'Subject',
            'Fakultas',
            'Tahun',
        ];
    }

    public function map($row): array
    {
        $subjects = array_values(array_filter([
            trim((string) $row->subject_1),
            trim((string) $row->subject_2),
        ]));

        $rawFaculty = trim((string) $row->fakultas);
        $facultyMap = [
            'pascasarjana' => 'SPs',
            'sps' => 'SPs',
            'sekolah pascasarjana' => 'SPs',
            'fip' => 'FIP',
            'fakultas ilmu pendidikan' => 'FIP',
            'fmipa' => 'FMIPA',
            'mipa' => 'FMIPA',
            'fakultas matematika dan ilmu pengetahuan alam' => 'FMIPA',
            'ft' => 'FT',
            'fakultas teknik' => 'FT',
            'fbs' => 'FBS',
            'fakultas bahasa dan seni' => 'FBS',
            'fe' => 'FEB',
            'feb' => 'FEB',
            'fakultas ekonomi dan bisnis' => 'FEB',
            'fakultas ekonomi' => 'FEB',
            'fis' => 'FISH',
            'fish' => 'FISH',
            'fakultas ilmu sosial dan hukum' => 'FISH',
            'fakultas ilmu sosial' => 'FISH',
            'fik' => 'FIKK',
            'fikk' => 'FIKK',
            'fakultas ilmu keolahragaan dan kesehatan' => 'FIKK',
            'fakultas ilmu keolahragaan' => 'FIKK',
            'fppsi' => 'FPsi',
            'fpsi' => 'FPsi',
            'fakultas psikologi' => 'FPsi',
            'kui' => 'KUI',
            'kantor urusan internasional' => 'KUI',
        ];

        $facultyKey = mb_strtolower($rawFaculty);
        $shortFaculty = $facultyMap[$facultyKey] ?? ($rawFaculty !== '' ? strtoupper($rawFaculty) : '-');

        return [
            $row->nama,
            $row->jenis_kelamin,
            $row->jabatan,
            $row->universitas_asal,
            $row->negara,
            $row->email,
            implode(', ', $subjects),
            $shortFaculty,
            $row->tahun,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F4E78'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D9E2F3'],
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Jangan membuat PhpSpreadsheet Table di sini.
                // Export memakai FromQuery dan jumlah baris bisa berubah/0,
                // sehingga addTable() dapat melempar:
                // "Table must be set on a range of cells."
                // AutoFilter tetap memberikan filter pada header tanpa risiko tersebut.
                $sheet->freezePane('A2');

                if ($lastRow >= 1 && $lastColumn !== '') {
                    $sheet->setAutoFilter("A1:{$lastColumn}{$lastRow}");
                }
                $sheet->getRowDimension(1)->setRowHeight(30);

                $widths = [
                    'A' => 28,
                    'B' => 18,
                    'C' => 25,
                    'D' => 34,
                    'E' => 20,
                    'F' => 34,
                    'G' => 30,
                ];

                foreach ($widths as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }

                if ($lastRow >= 2) {
                    $sheet->getStyle("A2:{$lastColumn}{$lastRow}")
                        ->getAlignment()
                        ->setVertical(Alignment::VERTICAL_TOP)
                        ->setWrapText(true);
                }
            },
        ];
    }
}
