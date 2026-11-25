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
    private string $importMode;
    private array $customFieldsSchema = [];
    private int $imported = 0;
    private int $updatedInSession = 0;
    private int $skipped = 0;
    private int $skippedInSession = 0;
    private int $skippedAlreadyAnswered = 0;
    private int $skippedNotInSession = 0;
    private int $skippedEmpty = 0;

    /**
     * @param int $sessionId
     * @param string $category Default/fallback category ('academic' or 'employee')
     * @param string $importMode 'add_only' | 'sync_all' | 'update_existing_only'
     */
    public function __construct(int $sessionId, string $category, string $importMode = 'add_only')
    {
        $this->sessionId = $sessionId;
        $this->category = $category;
        $this->importMode = $importMode;

        $session = QsSession::find($sessionId);
        if ($session) {
            $this->customFieldsSchema = $session->getCustomFieldsSchema();
        }
    }

    public function model(array $row)
    {
        $email = strtolower(trim($row['email'] ?? ''));
        $phone = $row['phone'] ?? ($row['phone_responden'] ?? null);

        if (empty($email)) {
            $this->skipped++;
            $this->skippedEmpty++;
            return null;
        }

        // Resolve category: prioritize row's 'category' / 'kategori' column if valid, else fallback to dropdown $this->category
        $rawRowCategory = $row['category'] ?? ($row['kategori'] ?? null);
        $resolvedCategory = RespondenBank::normalizeCategory($rawRowCategory) ?? $this->category;

        // Check if respondent already exists in THIS session by email
        $existingSessionResp = QsSessionRespondent::where('qs_session_id', $this->sessionId)
            ->whereHas('bankRespondent', function ($q) use ($email) {
                $q->where('email', $email);
            })
            ->with('bankRespondent')
            ->first();

        if ($existingSessionResp) {
            if (in_array($this->importMode, ['sync_all', 'update_existing_only'])) {
                $existingSessionResp->update([
                    'category' => $resolvedCategory,
                ]);

                if ($existingSessionResp->bankRespondent) {
                    $existingSessionResp->bankRespondent->update([
                        'category' => $resolvedCategory,
                    ]);
                }

                $this->updatedInSession++;
                return null;
            }

            // Default 'add_only' behavior: skip already in session
            $this->skipped++;
            $this->skippedInSession++;
            return null;
        }

        // If mode is 'update_existing_only', do not insert new respondents that aren't in this session
        if ($this->importMode === 'update_existing_only') {
            $this->skipped++;
            $this->skippedNotInSession++;
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

        $firstName = $row['first_name'] ?? $row['fullname'] ?? $row['full_name'] ?? $row['name'] ?? 'Unknown';
        $institution = $row['institution'] ?? $row['instansi'] ?? null;
        $jobTitle = $row['job_title'] ?? $row['jabatan'] ?? null;

        // Find or create in central bank
        $bankEntry = $dupCheck['bank_respondent'] ?? RespondenBank::firstOrCreate(
            ['email' => $email],
            [
                'title' => $row['title'] ?? null,
                'first_name' => $firstName,
                'last_name' => $row['last_name'] ?? null,
                'job_title' => $jobTitle,
                'institution' => $institution,
                'department' => $row['department'] ?? null,
                'company_name' => $row['company_name'] ?? $row['company'] ?? null,
                'position' => $row['position'] ?? null,
                'country' => $row['country'] ?? 'Indonesia',
                'phone' => $phone,
                'category' => $resolvedCategory,
                'source' => 'import',
                'source_user_id' => Auth::id(),
            ]
        );

        // If bankEntry already existed and we are in sync_all mode, keep category aligned
        if ($this->importMode === 'sync_all' && $bankEntry->category !== $resolvedCategory) {
            $bankEntry->update(['category' => $resolvedCategory]);
        }

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
            'category' => $resolvedCategory,
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

    public function getUpdatedInSessionCount(): int
    {
        return $this->updatedInSession;
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
        $parts = [];
        if ($this->imported > 0 || $this->importMode !== 'update_existing_only') {
            $parts[] = "{$this->imported} responden baru berhasil ditambahkan";
        }
        if ($this->updatedInSession > 0 || in_array($this->importMode, ['sync_all', 'update_existing_only'])) {
            $parts[] = "{$this->updatedInSession} responden yang sudah ada di sesi berhasil diperbarui kategorinya";
        }
        if ($this->skippedInSession > 0) {
            $parts[] = "{$this->skippedInSession} dilewati (sudah ada di sesi ini)";
        }
        if ($this->skippedNotInSession > 0) {
            $parts[] = "{$this->skippedNotInSession} dilewati (tidak ada di sesi ini - mode hanya update)";
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
