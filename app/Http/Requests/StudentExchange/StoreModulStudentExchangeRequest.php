<?php

namespace App\Http\Requests\StudentExchange;

use Illuminate\Foundation\Http\FormRequest;

class StoreModulStudentExchangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'admin_equity' || $this->user()->role === 'sub_admin_equity';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'urutan' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'judul_modul.required' => 'Judul modul wajib diisi.',
            'judul_modul.max' => 'Judul modul maksimal 255 karakter.',
            'periode_awal.date' => 'Periode awal harus berupa tanggal yang valid.',
            'periode_akhir.date' => 'Periode akhir harus berupa tanggal yang valid.',
            'periode_akhir.after_or_equal' => 'Periode akhir harus sama dengan atau setelah periode awal.',
            'urutan.required' => 'Urutan wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal 1.',
        ];
    }
}
