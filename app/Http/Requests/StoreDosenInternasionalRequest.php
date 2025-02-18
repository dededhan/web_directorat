<?php
// app/Http/Requests/StoreDosenInternasionalRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDosenInternasionalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fakultas' => 'required|in:fmipa,fik,ft,fbs,fip,fe,fis',
            'prodi' => 'required|string',
            'nama' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'universitas_asal' => 'required|string|max:255',
            'status' => 'required|in:fulltime,parttime',
            'bidang_keahlian' => 'required|string|max:255'
        ];
    }
}