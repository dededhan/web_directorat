<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaAcaraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 

    public function rules()
    {
        return [
            'hari' => 'required|string|max:20',
            'tanggal' => 'required|numeric|between:1,31',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|numeric|digits:4',
            'keterangan_tanggal' => 'required|string|max:50',
            'tempat' => 'required|string|max:100',
            'surat_keputusan' => 'required|string|max:100',
            'judul_inovasi' => 'required|string|max:200',
            'jenis_inovasi' => 'required|string|max:100',
            'nilai_tki' => 'required|numeric|between:0,100',
            'opini_penilai' => 'required|string|min:50|max:2000',
            'tanggal_penutupan' => 'required|date',
            'ttd_penanggungjawab' => 'required|string',
            'nama_penanggungjawab' => 'required|string|max:100',
            'ttd_ketua_tim' => 'required|string',
            'nama_ketua_tim' => 'required|string|max:100',
            'ttd_anggota1' => 'required|string',
            'nama_anggota1' => 'required|string|max:100',
            'ttd_anggota2' => 'required|string',
            'nama_anggota2' => 'required|string|max:100',
        ];
    }
}
