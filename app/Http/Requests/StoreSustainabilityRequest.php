<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSustainabilityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'fakultas' => 'required|in:pascasarjana,fip,fmipa,fppsi,fbs,ft,fik,fis,fe,profesi',
            'prodi' => 'nullable|string',
            'link_kegiatan' => 'nullable|url',
            'foto_kegiatan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi_kegiatan' => 'required|string',
        ];
    }
}