<?php

namespace App\Imports;

use App\Models\RespondenAnswer;
use App\Models\Responden;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class RespondenAnswerImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsErrors, SkipsFailures;
    
    protected $skipDuplicates;
    private $importedCount = 0;
    private $skippedCount = 0;
    
    public function __construct(bool $skipDuplicates = true)
    {
        $this->skipDuplicates = $skipDuplicates;
    }

    public function model(array $row)
    {
        Log::info('Processing QS Responden row from Excel:', $row);
        
        // Check for duplicates based on email
        if ($this->skipDuplicates && !empty($row['email'])) {
            $exists = RespondenAnswer::where('email', $row['email'])->exists();
            
            if ($exists) {
                Log::info('Skipping duplicate QS responden on import.', ['email' => $row['email']]);
                $this->skippedCount++;
                return null;
            }
        }
        
        Log::info('Creating new QS responden with data:', $row);
        
        // Try to find the related responden_id
        $respondenId = null;
        if (!empty($row['email'])) {
            $responden = Responden::where('email', $row['email'])->first();
            if ($responden) {
                $respondenId = $responden->id;
            }
        }

        $this->importedCount++;
        
        return new RespondenAnswer([
            'responden_id' => $respondenId,
            'title' => $row['title'] ?? null,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'institution' => $row['institution'] ?? null,
            'company_name' => $row['company_name'] ?? null,
            'job_title' => $row['job_title'] ?? null,
            'country' => $row['country'] ?? null,
            'email' => $row['email'],
            'phone' => $row['phone'] ?? null,
            'survey_2023' => $row['survey_2023'] ?? 'no',
            'survey_2024' => $row['survey_2024'] ?? 'no',
            'category' => $row['category'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable',
            'first_name' => 'required',
            'last_name' => 'required',
            'institution' => 'nullable',
            'company_name' => 'nullable',
            'job_title' => 'nullable',
            'country' => 'nullable',
            'email' => 'required|email',
            'phone' => 'nullable',
            'survey_2023' => 'nullable',
            'survey_2024' => 'nullable',
            'category' => 'required|in:academic,employee,employer',
        ];
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }
}
