<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlumniBerdampakRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul_berita' => 'required|string|max:255',
            'tanggal_berita' => 'required|date',
            'fakultas' => 'required|in:pascasarjana,fip,fmipa,fppsi,fbs,ft,fik,fis,fe,profesi',
            // 'prodi' => 'nullable|string',
            'link_berita' => 'required|url|max:500',
            'image'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}