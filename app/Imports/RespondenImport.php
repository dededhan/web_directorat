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

class RespondenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsErrors, SkipsFailures;
    
    protected $skipDuplicates;
    
    public function __construct($skipDuplicates = true)
    {
        $this->skipDuplicates = $skipDuplicates;
    }

    public function model(array $row)
    {
        // Skip empty rows by checking if essential fields are empty
        if (empty($row['email']) && empty($row['fullname']) && empty($row['jabatan'])) {
            return null;
        }
        
        if ($this->skipDuplicates) {
            $exists = Responden::where('email', $row['email'])
                ->orWhere('phone_responden', $row['phone_responden'] ?? null)
                ->exists();
                
            if ($exists) {
                return null;
            }
        }
        
        return new Responden([
            'title' => $row['title'],
            'fullname' => $row['fullname'],
            'jabatan' => $row['jabatan'],
            'instansi' => $row['instansi'],
            'email' => $row['email'],
            'phone_responden' => $row['phone_responden'] ?? null,
            'nama_dosen_pengusul' => $row['nama_dosen_pengusul'],
            'phone_dosen' => $row['phone_dosen'],
           'fakultas' => strtolower($row['fakultas']), 
            'category' => $row['category'],
            'status' => 'belum'
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
            'nama_dosen_pengusul' => 'required',
            'phone_dosen' => 'required',
            'fakultas' => 'required',
            'category' => 'required'
        ];
    }
}