<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMataKuliahRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'nama_matkul' => 'required|string|max:200',
            'semester' => 'required|string|max:20',
            'kode_matkul' => 'required|string|max:20',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'deskripsi' => 'required|string|min:100',
        ];
    
        // Untuk create, RPS wajib diisi
        if ($this->isMethod('post')) {
            $rules['rps'] = 'required|file|mimes:pdf,doc,docx|max:10240';
        }
        // Untuk update, RPS optional
        elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['rps'] = 'nullable|file|mimes:pdf,doc,docx|max:10240';
        }
    
        return $rules;
    }
}