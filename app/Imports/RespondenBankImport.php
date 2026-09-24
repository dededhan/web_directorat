<?php

namespace App\Imports;

use App\Models\RespondenBank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class RespondenBankImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private int $userId;
    private int $imported = 0;
    private int $skipped = 0;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $email = strtolower(trim($row['email'] ?? ''));

        if (empty($email)) {
            $this->skipped++;
            return null;
        }

        // Check if already exists
        if (RespondenBank::where('email', $email)->exists()) {
            $this->skipped++;
            return null;
        }

        $this->imported++;

        return new RespondenBank([
            'email' => $email,
            'title' => $row['title'] ?? null,
            'first_name' => $row['first_name'] ?? $row['name'] ?? 'Unknown',
            'last_name' => $row['last_name'] ?? null,
            'job_title' => $row['job_title'] ?? null,
            'institution' => $row['institution'] ?? null,
            'department' => $row['department'] ?? null,
            'company_name' => $row['company_name'] ?? $row['company'] ?? null,
            'position' => $row['position'] ?? null,
            'country' => $row['country'] ?? 'Indonesia',
            'phone' => $row['phone'] ?? null,
            'category' => RespondenBank::normalizeCategory($row['category'] ?? null),
            'source' => 'import',
            'source_user_id' => $this->userId,
        ]);
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }

    public function getSkippedCount(): int
    {
        return $this->skipped;
    }
}
