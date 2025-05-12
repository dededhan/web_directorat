<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternationalFacultyStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'universitas_asal' => 'required|string|max:255',
            'bidang_keahlian' => 'required|string|max:255',
            'qs_wur' => 'nullable|string|max:255',
            'qs_subject' => 'nullable|string|max:255',
            'scopus' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tahun' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'category' => 'required|in:fulltime,adjunct',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'nama' => 'Nama',
            'fakultas' => 'Fakultas',
            'universitas_asal' => 'Universitas Asal',
            'bidang_keahlian' => 'Bidang Keahlian',
            'qs_wur' => 'QS WUR',
            'qs_subject' => 'QS Subject',
            'scopus' => 'Scopus',
            'foto' => 'Foto',
            'tahun' => 'Tahun',
            'category' => 'Category',
        ];
    }
}