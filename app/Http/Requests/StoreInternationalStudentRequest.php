<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternationalStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'nullable|string|max:20|unique:international_students,nim',
            'negara' => 'required|string|max:100',
            'kategori' => 'required|in:inbound,outbound',
            'status' => 'required|in:fulltime,parttime,other',
            'fakultas' => 'nullable|string|max:100',
            'program_studi' => 'nullable|string|max:100',
            'periode_mulai' => 'required|date',
            'periode_akhir' => 'required|date|after:periode_mulai',
        ];
    }
}