<?php
// File: app/Http/Requests/StoreAkreditasiRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAkreditasiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fakultas' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'lembaga_akreditasi' => 'required|string|max:255',
            'peringkat' => 'required|string|max:255',
            'nomor_sk' => 'required|string|max:255',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after:periode_awal'
        ];
    }
}