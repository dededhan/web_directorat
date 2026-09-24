<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SessionDetailSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $data;
    protected $counter = 0;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Detail Responden';
    }

    public function headings(): array
    {
        return [
            'No',
            'Sesi Kampanye',
            'Nama Responden',
            'Email',
            'No. Telepon',
            'Institusi / Perusahaan',
            'Jabatan / Posisi',
            'Kategori',
            'Diinput Oleh (Unit)',
            'Status Persetujuan',
            'Email Terkirim',
            'Tanggal Kirim Email',
            'Tanggal Persetujuan / Form',
        ];
    }

    public function map($row): array
    {
        $this->counter++;

        $sr = $row;
        $session = $sr->session;
        $bank = $sr->bankRespondent;
        $user = $sr->addedByUser;

        $name = $bank ? trim(($bank->first_name ?? '') . ' ' . ($bank->last_name ?? '')) : '-';
        if (empty($name)) {
            $name = $bank->email ?? '-';
        }

        $institution = $bank->institution ?? $bank->company_name ?? '-';
        $jobTitle = $bank->job_title ?? $bank->position ?? '-';

        $consentStatusLabel = match ($sr->consent_status) {
            'agreed' => 'Setuju (Agreed)',
            'declined' => 'Menolak (Declined)',
            default => 'Pending (Menunggu)',
        };

        $emailStatus = $sr->email_sent_at ? 'Sudah (' . $sr->email_count . 'x)' : 'Belum';
        $emailDate = $sr->email_sent_at ? $sr->email_sent_at->format('d/m/Y H:i') : '-';
        $consentDate = $sr->consented_at ? $sr->consented_at->format('d/m/Y H:i') : ($sr->form_submitted_at ? $sr->form_submitted_at->format('d/m/Y H:i') : '-');

        return [
            $this->counter,
            $session->name ?? '-',
            $name,
            $bank->email ?? '-',
            $bank->phone ?? '-',
            $institution,
            $jobTitle,
            ucfirst($sr->category ?? '-'),
            $sr->added_by_label ?? '-',
            $consentStatusLabel,
            $emailStatus,
            $emailDate,
            $consentDate,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Header style
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D9488'], // Teal 600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        if ($lastRow > 1) {
            $sheet->getStyle("A2:M{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alignments
            $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("H2:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("L2:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return [];
    }
}
