<?php

namespace App\Http\Requests;

use App\Services\LecturerDataSanitizer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDosenInternasionalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        if ($this->has('negara')) {
            $merge['negara'] = LecturerDataSanitizer::normalizeCountry($this->input('negara')) ?? $this->input('negara');
        }
        if ($this->has('subject_1')) {
            $merge['subject_1'] = LecturerDataSanitizer::normalizeSubject(
                $this->input('subject_1'),
                $this->input('fakultas'),
                $this->input('prodi')
            ) ?? $this->input('subject_1');
        }
        if ($merge) {
            $this->merge($merge);
        }
    }

    public function rules()
    {
        return [
            // Identitas Dosen (Wajib)
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Male,Female,Other',
            'jabatan' => 'required|string|max:255',
            'universitas_asal' => 'required|string|max:255',
            'negara' => ['required', 'string', 'max:255', Rule::in(config('international_lecture.countries', []))],
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $reason = null;
                    if (!\App\Services\LecturerDataSanitizer::isFixDeliverableEmail($value, $reason)) {
                        $fail("Email tidak valid: {$reason}.");
                    }
                },
            ],
            'subject_1' => ['required', 'string', 'max:255', Rule::in(config('international_lecture.subjects', []))],

            // Academic Details
            'fakultas' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'sesi' => 'required|string|max:50',
            'tahun' => 'required|string|max:10',
            'link_bukti_kegiatan' => 'nullable|string|max:1000',
            'tanggal' => 'required|date',

            // Dihapus dari form
            'subject_2' => 'nullable|string|max:255',
            'bidang_keahlian' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama dosen asing wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jabatan.required' => 'Jabatan wajib dipilih.',
            'universitas_asal.required' => 'Institusi asal wajib diisi.',
            'negara.required' => 'Negara wajib diisi.',
            'negara.in' => 'Negara harus dipilih dari daftar negara yang tersedia.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject_1.required' => 'Subject wajib dipilih.',
            'subject_1.in' => 'Subject harus dipilih dari daftar resmi QS.',
            'fakultas.required' => 'Fakultas wajib dipilih.',
            'tahun.required' => 'Tahun Dosen Datang wajib diisi.',
            'sesi.required' => 'Sesi (Semester) wajib diisi.',
            'status.required' => 'Kegiatan dosen di kampus wajib dipilih.',
            'tanggal.required' => 'Tanggal Kegiatan wajib diisi.',
            'tanggal.date' => 'Format Tanggal Kegiatan tidak valid.',
        ];
    }
}
