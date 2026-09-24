<?php

namespace App\Imports;

use App\Models\QsSession;
use App\Models\RespondenBank;
use App\Models\QsSessionRespondent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SessionRespondentImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    private int $sessionId;
    private string $category;
    private array $customFieldsSchema = [];
    private int $imported = 0;
    private int $skipped = 0;
    private int $skippedInSession = 0;
    private int $skippedAlreadyAnswered = 0;
    private int $skippedEmpty = 0;

    public function __construct(int $sessionId, string $category)
    {
        $this->sessionId = $sessionId;
        $this->category = $category;

        $session = QsSession::find($sessionId);
        if ($session) {
            $this->customFieldsSchema = $session->getCustomFieldsSchema();
        }
    }

    public function model(array $row)
    {
        $email = strtolower(trim($row['email'] ?? ''));
        $phone = $row['phone'] ?? null;

        if (empty($email)) {
            $this->skipped++;
            $this->skippedEmpty++;
            return null;
        }

        // Smart duplicate check (checks this session, already answered in bank, or pending in other session)
        $dupCheck = RespondenBank::checkDuplicateStatus($this->sessionId, $email, $phone);

        if (!$dupCheck['allowed']) {
            $this->skipped++;
            if ($dupCheck['status'] === 'already_in_session') {
                $this->skippedInSession++;
            } elseif ($dupCheck['status'] === 'already_answered') {
                $this->skippedAlreadyAnswered++;
            }
            return null;
        }

        // Find or create in central bank (do not overwrite existing data)
        $bankEntry = $dupCheck['bank_respondent'] ?? RespondenBank::firstOrCreate(
            ['email' => $email],
            [
                'title' => $row['title'] ?? null,
                'first_name' => $row['first_name'] ?? $row['name'] ?? 'Unknown',
                'last_name' => $row['last_name'] ?? null,
                'job_title' => $row['job_title'] ?? null,
                'institution' => $row['institution'] ?? null,
                'department' => $row['department'] ?? null,
                'company_name' => $row['company_name'] ?? $row['company'] ?? null,
                'position' => $row['position'] ?? null,
                'country' => $row['country'] ?? 'Indonesia',
                'phone' => $phone,
                'category' => RespondenBank::normalizeCategory($row['category'] ?? $this->category),
                'source' => 'import',
                'source_user_id' => Auth::id(),
            ]
        );

        // Extract custom fields according to session schema
        $customValues = [];
        foreach ($this->customFieldsSchema as $field) {
            $key = $field['key'] ?? '';
            $labelSlug = Str::slug($field['label'] ?? '', '_');

            if ($key && isset($row[$key])) {
                $customValues[$key] = $row[$key];
            } elseif ($labelSlug && isset($row[$labelSlug])) {
                $customValues[$key] = $row[$labelSlug];
            }
        }

        $this->imported++;

        // Create session respondent
        QsSessionRespondent::create([
            'qs_session_id' => $this->sessionId,
            'responden_bank_id' => $bankEntry->id,
            'category' => $this->category,
            'custom_fields' => !empty($customValues) ? $customValues : null,
            'token' => Str::random(64),
            'added_by' => Auth::id(),
        ]);

        return null;
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }

    public function getSkippedCount(): int
    {
        return $this->skipped;
    }

    public function getSkippedInSessionCount(): int
    {
        return $this->skippedInSession;
    }

    public function getSkippedAlreadyAnsweredCount(): int
    {
        return $this->skippedAlreadyAnswered;
    }

    public function getSummaryMessage(): string
    {
        $parts = ["{$this->imported} responden berhasil ditambahkan"];
        if ($this->skippedInSession > 0) {
            $parts[] = "{$this->skippedInSession} dilewati (sudah ada di sesi ini)";
        }
        if ($this->skippedAlreadyAnswered > 0) {
            $parts[] = "{$this->skippedAlreadyAnswered} dilewati (sudah di Bank Responden / sudah pernah menjawab)";
        }
        if ($this->skippedEmpty > 0) {
            $parts[] = "{$this->skippedEmpty} baris tanpa email";
        }
        return implode(', ', $parts) . '.';
    }
}
