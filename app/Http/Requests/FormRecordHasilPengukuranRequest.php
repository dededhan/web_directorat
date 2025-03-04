<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRecordHasilPengukuranRequest extends FormRequest
{
    public function authorize()
    {
        // Ubah sesuai kebutuhan autentikasi
        return true;
    }

    public function rules()
    {
        return [
            'nama_penanggung_jawab' => 'required|string|max:255',
            'institusi'             => 'required|string|max:255',
            'judul_inovasi'         => 'required|string|max:255',
            'jenis_inovasi'         => 'required|string|max:255',
            'alamat_kontak'         => 'required|string',
            'phone'                 => 'required|string|max:20',
            'fax'                   => 'required|string|max:20',
            'tanggal_penilaian'     => 'required|date',

            // Validasi untuk masing-masing baris (1 s.d. 5)
            'aspek_1'      => 'required|string|max:255',
            'aktivitas_1'  => 'required|string|max:255',
            'capaian_1'    => 'required|integer|min:0|max:100',
            'keterangan_1' => 'required|string|max:255',
            'catatan_1'    => 'required|string|max:255',

            'aspek_2'      => 'required|string|max:255',
            'aktivitas_2'  => 'required|string|max:255',
            'capaian_2'    => 'required|integer|min:0|max:100',
            'keterangan_2' => 'required|string|max:255',
            'catatan_2'    => 'required|string|max:255',

            'aspek_3'      => 'required|string|max:255',
            'aktivitas_3'  => 'required|string|max:255',
            'capaian_3'    => 'required|integer|min:0|max:100',
            'keterangan_3' => 'required|string|max:255',
            'catatan_3'    => 'required|string|max:255',

            'aspek_4'      => 'required|string|max:255',
            'aktivitas_4'  => 'required|string|max:255',
            'capaian_4'    => 'required|integer|min:0|max:100',
            'keterangan_4' => 'required|string|max:255',
            'catatan_4'    => 'required|string|max:255',

            'aspek_5'      => 'required|string|max:255',
            'aktivitas_5'  => 'required|string|max:255',
            'capaian_5'    => 'required|integer|min:0|max:100',
            'keterangan_5' => 'required|string|max:255',
            'catatan_5'    => 'required|string|max:255',
        ];
    }
}
