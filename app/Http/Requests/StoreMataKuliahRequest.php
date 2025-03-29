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
        return [
            'nama_matkul' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'kode_matkul' => 'required|string|max:255|unique:mata_kuliahs,kode_matkul',
            'fakultas' => 'required|in:pascasarjana,fip,fmipa,fppsi,fbs,ft,fik,fis,fe,profesi',
            'prodi' => 'required|string|max:255',
            'rps' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'deskripsi' => 'required|string',
        ];
    }
}