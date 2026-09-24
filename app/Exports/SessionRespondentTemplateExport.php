<?php

namespace App\Exports;

use App\Models\QsSession;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SessionRespondentTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected QsSession $session;
    protected array $customFieldsSchema;

    public function __construct(QsSession $session)
    {
        $this->session = $session;
        $this->customFieldsSchema = $session->getCustomFieldsSchema();
    }

    public function headings(): array
    {
        $headers = [
            'email',
            'first_name',
            'last_name',
            'title',
            'phone',
            'country',
            'institution',
            'company_name',
            'department',
            'job_title',
        ];

        // Append custom field keys configured for this session
        foreach ($this->customFieldsSchema as $field) {
            $headers[] = $field['key'] ?? 'custom_field';
        }

        return $headers;
    }

    public function array(): array
    {
        // Sample Row 1: Academic
        $row1 = [
            'prof.budi@university.ac.id',
            'Budi',
            'Santoso',
            'Prof. Dr.',
            '081234567890',
            'Indonesia',
            'Universitas Negeri Jakarta',
            '',
            'Fakultas Matematika dan IPA',
            'Guru Besar / Dosen Senior',
        ];

        // Sample Row 2: Employer
        $row2 = [
            'sarah.wijaya@company.co.id',
            'Sarah',
            'Wijaya',
            'Ms.',
            '081987654321',
            'Indonesia',
            '',
            'PT Teknologi Edukasi Nusantara',
            'Human Capital & Talent Development',
            'Director of Human Resources',
        ];

        // Add dummy values for custom fields if any
        foreach ($this->customFieldsSchema as $field) {
            $label = $field['label'] ?? $field['key'];
            $row1[] = "Contoh {$label}";
            $row2[] = "Contoh {$label}";
        }

        return [$row1, $row2];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0D9488'], // Teal 600
                ],
            ],
        ];
    }
}
