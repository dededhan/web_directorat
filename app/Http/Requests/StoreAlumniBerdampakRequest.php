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
        $prodiOptions = [
            'fmipa' => ['ilmu_komputer', 'matematika', 'pendidikan_matematika', 'fisika', 'pendidikan_fisika', 'biologi', 'pendidikan_biologi', 'kimia', 'pendidikan_kimia'],
            'fik' => ['pendidikan_teknologi_informasi', 'pendidikan_teknik_elektronika', 'pendidikan_teknik_elektro', 'teknik_informatika_dan_komputer'],
            'ft' => ['teknik_sipil', 'teknik_mesin', 'teknik_elektro', 'pendidikan_teknik_bangunan', 'pendidikan_teknik_mesin'],
            'fbs' => ['pendidikan_bahasa_indonesia', 'pendidikan_bahasa_inggris', 'pendidikan_bahasa_jerman', 'pendidikan_bahasa_prancis', 'pendidikan_seni_rupa'],
            'fip' => ['pendidikan_guru_sekolah_dasar', 'pendidikan_anak_usia_dini', 'bimbingan_dan_konseling', 'teknologi_pendidikan', 'pendidikan_luar_biasa'],
            'fe' => ['pendidikan_ekonomi', 'manajemen', 'akuntansi', 'pendidikan_administrasi_perkantoran'],
            'fis' => ['pendidikan_pancasila_dan_kewarganegaraan', 'pendidikan_sejarah', 'pendidikan_geografi', 'pendidikan_sosiologi', 'ilmu_komunikasi'],
        ];

        return [
            'judul_berita' => 'required|string|max:255',
            'tanggal_berita' => 'required|date',
            'fakultas' => [
                'required',
                Rule::in(array_keys($prodiOptions))
            ],
            'prodi' => [
                'required',
                function ($attribute, $value, $fail) use ($prodiOptions) {
                    $fakultas = $this->input('fakultas');
                    if (!in_array($value, $prodiOptions[$fakultas] ?? [])) {
                        $fail('Program Studi tidak valid untuk fakultas ini.');
                    }
                },
            ],
            'link_berita' => 'required|url|max:500',
        ];
    }
}