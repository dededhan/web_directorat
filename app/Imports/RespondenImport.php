<?php

namespace App\Imports;

use App\Models\Responden;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class RespondenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors, SkipsFailures;
    
    protected $skipDuplicates;
    
    public function __construct($skipDuplicates = true)
    {
        $this->skipDuplicates = $skipDuplicates;
    }

    public function model(array $row)
    {
        if ($this->skipDuplicates) {
            $exists = Responden::where('email', $row['email'])
                ->orWhere('phone_responden', $row['phone_responden'])
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
            'phone_responden' => $row['phone_responden'],
            'nama_dosen_pengusul' => $row['nama_dosen_pengusul'],
            'phone_dosen' => $row['phone_dosen'],
            'fakultas' => $row['fakultas'],
            'category' => $row['category'],
            'status' => 'belum'
        ]);
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'phone_responden' => 'required',
            'fullname' => 'required',
            'jabatan' => 'required',
            'instansi' => 'required'
        ];
    }
}