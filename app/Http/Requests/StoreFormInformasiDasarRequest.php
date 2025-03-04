<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormInformasiDasarRequest extends FormRequest
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
            // Section 1
            'nama_penanggungjawab' => 'required|string',
            'institusi' => 'required|string',
            'alamat_kontak' => 'required|string',
            'phone' => 'required|string',
            'fax' => 'required|string',
            
            'team_members' => 'required|array',
            'team_members.*.nama' => 'required|string',
            'team_members.*.keahlian' => 'required|string',
            
            // Section 2
            'judul_inovasi' => 'required|string',
            'nama_program' => 'required|string',
            'jenis_inovasi' => 'required|string',
            'jenis_lainnya' => 'nullable|string',
            'bidang_inovasi' => 'required|string',
            'bidang_lainnya' => 'nullable|string',
            'aplikasi_manfaat' => 'required|string',
            'lama_program' => 'required|string',
            'tahun_berjalan' => 'required|string',
            
            // 'funding_sources' => 'required|array',
            // 'funding_sources.*.tahun_ke' => 'required|string',
            // 'funding_sources.*.total_dana' => 'required|numeric',
            // 'funding_sources.*.sumber_dana' => 'required|string',
            
            // 'partners' => 'required|array',
            // 'partners.*.nama_mitra' => 'required|string',
            // 'partners.*.alamat_mitra' => 'required|string',
            // 'partners.*.peran_mitra' => 'required|string',
            // 'partners.*.status_kerjasama' => 'required|string',
            'funding_sources.*.tahun_ke' => 'nullable|string',
            'funding_sources.*.total_dana' => 'nullable|numeric',
            'funding_sources.*.sumber_dana' => 'nullable|string',
            
            'partners.*.nama_mitra' => 'nullable|string',
            'partners.*.alamat_mitra' => 'nullable|string',
            'partners.*.peran_mitra' => 'nullable|string',
            'partners.*.status_kerjasama' => 'nullable|string',
            
            'ringkasan_inovasi' => 'required|string',
            'kebaruan' => 'required|string',
            'keunggulan' => 'required|string',
            
            // Section 3
            'technology_progress' => 'required|array',
            'technology_progress.*.uraian' => 'required|string',
            'technology_progress.*.status' => 'required|in:belum,sudah',
            'technology_progress.*.keterangan' => 'nullable|string',
            
            'market_progress' => 'required|array',
            'market_progress.*.uraian' => 'required|string',
            'market_progress.*.status' => 'required|in:belum,sudah',
            'market_progress.*.keterangan' => 'nullable|string',
        ];
    }
}
