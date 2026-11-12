<?php

namespace App\Exports\Hackaton;

use App\Models\HackatonSession;
use App\Models\HackatonSubmission;
use App\Models\HackatonSubmissionFieldValue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionFieldValuesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected HackatonSession $session;
    protected Collection $submissions;
    protected Collection $tahapList;
    protected Collection $orderedFields;
    protected array $fieldValueMap = [];
    protected array $renamedFileMap = [];
    private int $rowNumber = 1;

    /**
     * @param HackatonSession $session
     * @param iterable $submissions
     * @param int|null $tahapId Optional filter for a specific Tahap
     * @param array $renamedFileMap Optional map [submission_id][field_id] => renamed_filename
     */
    public function __construct(
        HackatonSession $session,
        iterable $submissions,
        ?int $tahapId = null,
        array $renamedFileMap = []
    ) {
        $this->session = $session;
        $this->submissions = collect($submissions);
        $this->renamedFileMap = $renamedFileMap;

        $tahapQuery = $session->tahap()
            ->with(['fields' => fn($q) => $q->orderBy('urutan')->orderBy('id'), 'sections'])
            ->orderBy('tahap_ke');

        if ($tahapId) {
            $tahapQuery->where('id', $tahapId);
        }

        $this->tahapList = $tahapQuery->get();

        $fields = collect();
        foreach ($this->tahapList as $tahap) {
            foreach ($tahap->fields as $field) {
                $field->setRelation('tahap', $tahap);
                $fields->push($field);
            }
        }
        $this->orderedFields = $fields;

        $submissionIds = $this->submissions->pluck('id')->all();
        if (!empty($submissionIds)) {
            $fvQuery = HackatonSubmissionFieldValue::whereIn('hackaton_submission_id', $submissionIds);
            if ($tahapId) {
                $fvQuery->where('hackaton_tahap_id', $tahapId);
            }
            foreach ($fvQuery->get() as $fv) {
                $this->fieldValueMap[$fv->hackaton_submission_id][$fv->hackaton_tahap_field_id] = $fv->value;
            }
        }
    }

    public function title(): string
    {
        return 'Rekap Isian Field';
    }

    public function collection()
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Kategori',
            'Nama Produk / Inovasi',
            'Nama Ketua / Pengusul',
            'Email Ketua',
            'Fakultas / Institusi Ketua',
            'Skema Inovasi',
            'Bidang Utama Produk',
            'Status Proposal',
        ];

        foreach ($this->orderedFields as $field) {
            $tk = $field->tahap->tahap_ke ?? '?';
            $headings[] = "[Tahap {$tk}] {$field->field_label}";
        }

        return $headings;
    }

    public function map($submission): array
    {
        $isDFarm = $submission->kategori === 'd-farm' || str_contains($submission->tema ?? '', 'D-FARM');
        $kategoriLabel = $isDFarm ? 'D-FARM' : 'D-MARC';

        $ketuaMember = $submission->members?->firstWhere('peran', 'Ketua');
        $institusiKetua = $ketuaMember?->institusi_fakultas
            ?? $submission->user?->profile?->fakultas?->name
            ?? $submission->user?->profile?->institusi
            ?? '-';

        $statusLabel = is_object($submission->status) && method_exists($submission->status, 'label')
            ? $submission->status->label()
            : ucfirst(str_replace('_', ' ', (string) ($submission->status ?? '-')));

        $row = [
            $this->rowNumber++,
            $kategoriLabel,
            $submission->identitas?->nama_produk ?? 'Belum Diisi',
            $submission->user?->name ?? '-',
            $submission->user?->email ?? '-',
            $institusiKetua,
            $submission->identitas?->skema_inovasi ?? '-',
            $submission->identitas?->bidang_utama_produk ?? '-',
            $statusLabel,
        ];

        foreach ($this->orderedFields as $field) {
            $rawVal = $this->fieldValueMap[$submission->id][$field->id] ?? null;

            if ($rawVal === null || $rawVal === '') {
                $row[] = '-';
                continue;
            }

            if ($field->field_type === 'file') {
                $renamed = $this->renamedFileMap[$submission->id][$field->id]
                    ?? self::formatRenamedFilename($submission, $field->tahap->tahap_ke ?? 1, $field->field_label, $rawVal);
                $row[] = $renamed;
            } elseif ($field->field_type === 'checkbox') {
                $decoded = json_decode($rawVal, true);
                $row[] = is_array($decoded) ? implode(', ', $decoded) : (string) $rawVal;
            } else {
                $row[] = (string) $rawVal;
            }
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Format a clean, filesystem-safe segment while preserving readability.
     */
    public static function sanitizeSegment(?string $text, string $fallback = 'Item', int $maxLength = 60): string
    {
        $text = trim((string) $text);
        if ($text === '') {
            return $fallback;
        }

        // Remove characters invalid in Windows/Linux/ZIP paths
        $clean = preg_replace('/[\/\\\\:*?"<>|\r\n\t]+/', ' ', $text);
        $clean = preg_replace('/\s+/', '-', trim($clean));
        $clean = preg_replace('/[^A-Za-z0-9_\-\.\(\)]+/', '', $clean);
        $clean = preg_replace('/-+/', '-', $clean);
        $clean = trim($clean, '-. _');

        if ($clean === '') {
            return $fallback;
        }

        return mb_substr($clean, 0, $maxLength);
    }

    /**
     * Build the standardized renamed filename:
     * {Kategori}_{Nama_Produk}_Tahap-{N}_{Label_Field}.{ext}
     */
    public static function formatRenamedFilename(
        HackatonSubmission $submission,
        int|string $tahapKe,
        string $fieldLabel,
        string $storedFilePath,
        ?int $duplicateIndex = null
    ): string {
        $isDFarm = $submission->kategori === 'd-farm' || str_contains($submission->tema ?? '', 'D-FARM');
        $kategori = $isDFarm ? 'D-FARM' : 'D-MARC';

        $produk = self::sanitizeSegment(
            $submission->identitas?->nama_produk ?: ($submission->user?->name ?: 'Proposal-' . $submission->id),
            'Proposal-' . $submission->id,
            55
        );

        $tahapPart = 'Tahap-' . $tahapKe;
        $labelPart = self::sanitizeSegment($fieldLabel, 'Berkas', 50);

        $ext = strtolower(pathinfo($storedFilePath, PATHINFO_EXTENSION));
        $suffix = ($duplicateIndex && $duplicateIndex > 1) ? "-{$duplicateIndex}" : '';

        $baseName = "{$kategori}_{$produk}_{$tahapPart}_{$labelPart}{$suffix}";

        return $ext ? "{$baseName}.{$ext}" : $baseName;
    }
}

