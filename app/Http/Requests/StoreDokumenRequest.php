<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokumenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kategori' => 'required|in:umum,pemeringkatan,inovasi',
            'tanggal' => 'required|date',
            'judul_dokumen' => 'required|max:200',
            'deskripsi' => 'nullable',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ];
    }
}