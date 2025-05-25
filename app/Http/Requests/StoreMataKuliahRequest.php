<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreMataKuliahRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;
        $fakultasValidation = 'required|string|max:50';
        $prodiValidation = 'nullable|string|max:255';
        $validFakultasValues = ['pascasarjana', 'fip', 'fmipa', 'fppsi', 'fbs', 'ft', 'fik', 'fis', 'fe', 'profesi'];
        if ($role === 'admin_direktorat' || $role === 'admin_pemeringkatan') {
            $fakultasValidation = ['required', 'string', Rule::in($validFakultasValues)];
        } elseif ($role === 'fakultas' || $role === 'prodi') {
            $fakultasValidation = 'nullable|string|max:50';
            $prodiValidation = 'nullable|string|max:255';
        }

        $rules = [
            'nama_matkul' => 'required|string|max:200',
            'semester' => 'required|string|max:20',
            'kode_matkul' => 'required|string|max:20|unique:mata_kuliahs,kode_matkul,' . ($this->matakuliah->id ?? 'NULL') . ',id', // Unique kode_matkul, ignoring current on update
            'fakultas' => $fakultasValidation,
            'prodi' => $prodiValidation,
            'deskripsi' => 'required|string|min:50',

        ];
    
        if ($this->isMethod('post')) { 
            $rules['rps'] = 'required|file|mimes:pdf,doc,docx|max:10240';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['rps'] = 'nullable|file|mimes:pdf,doc,docx|max:10240';
        }
    
        return $rules;
    }

    public function messages()
    {
        return [
            'nama_matkul.required' => 'Nama mata kuliah wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'kode_matkul.required' => 'Kode mata kuliah wajib diisi.',
            'kode_matkul.unique' => 'Kode mata kuliah sudah ada.',
            'fakultas.required' => 'Fakultas wajib dipilih.',
            'fakultas.in' => 'Fakultas yang dipilih tidak valid.',
            'deskripsi.required' => 'Deskripsi mata kuliah wajib diisi.',
            'deskripsi.min' => 'Deskripsi mata kuliah minimal harus 50 karakter.',
            'rps.required' => 'File RPS wajib diunggah saat membuat mata kuliah baru.',
            'rps.file' => 'RPS harus berupa file.',
            'rps.mimes' => 'Format file RPS harus PDF, DOC, atau DOCX.',
            'rps.max' => 'Ukuran file RPS tidak boleh melebihi 10MB.',
        ];
    }
}
