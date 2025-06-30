<?php

namespace App\Imports;

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
use Illuminate\Http\JsonResponse;



class RespondenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsErrors, SkipsFailures;
    
    protected $skipDuplicates;
    private $importedCount = 0;
    private $skippedCount = 0;
    private $userId;
    
    public function __construct(int $userId, bool $skipDuplicates = true)
    {
        $this->userId = $userId;
        $this->skipDuplicates = $skipDuplicates;
    }

    public function model(array $row)
    {
        Log::info('Processing row from Excel:', $row);
        // Pengecekan duplikat
        if ($this->skipDuplicates) {
            $query = Responden::query()->where('email', $row['email']);

            if (!empty($row['phone_responden'])) {
                $query->orWhere('phone_responden', $row['phone_responden']);
            }
            
            if ($query->exists()) {
                Log::info('Skipping duplicate respondent on import.', ['email' => $row['email'], 'phone' => $row['phone_responden'] ?? 'empty']);
                 $this->skippedCount++;
                return null; // Lewatkan baris ini karena dianggap duplikat
            }
        }
        Log::info('Creating new respondent with data:', $row);

         $this->importedCount++;
        return new Responden([
            'title' => $row['title'],
            'fullname' => $row['fullname'],
            'jabatan' => $row['jabatan'],
            'instansi' => $row['instansi'],
            'email' => $row['email'],
            'phone_responden' => $row['phone_responden'] ?? null, // Aman jika kolom tidak ada/kosong
            'nama_dosen_pengusul' => $row['nama_dosen_pengusul'] ?? null,
            'phone_dosen' => $row['phone_dosen'] ?? null,
            'fakultas' => $row['fakultas'], 
            'category' => $row['category'],
            'status' => 'belum',
            'user_id' => $this->userId, // The Fix!
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'email' => 'required|email',
            'fullname' => 'required',
            'jabatan' => 'required',
            'instansi' => 'required',
            'nama_dosen_pengusul' => 'nullable',
            'phone_dosen' => 'nullable',
            'phone_responden' => 'nullable',
            'fakultas' => 'required',
            'category' => 'required'
        ];
    }
    // [TAMBAHKAN] Getter methods untuk mengambil hasil hitungan
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }
}