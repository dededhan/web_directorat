<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kategori' => 'required|in:inovasi,pemeringkatan',
            'tanggal' => 'required|date',
            'judul_berita' => 'required|string|max:200',
            'isi_berita' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function attributes()
    {
        return [
            'judul_berita' => 'judul berita',
            'isi_berita' => 'isi berita'
        ];
    }
}