<?php

namespace App\Http\Requests\StudentExchange;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSesiStudentExchangeRequest extends FormRequest
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
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:dibuka,ditutup',
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
            'nama_sesi.required' => 'Nama sesi wajib diisi.',
            'nama_sesi.max' => 'Nama sesi maksimal 255 karakter.',
            'periode_awal.required' => 'Periode awal wajib diisi.',
            'periode_awal.date' => 'Periode awal harus berupa tanggal yang valid.',
            'periode_akhir.required' => 'Periode akhir wajib diisi.',
            'periode_akhir.date' => 'Periode akhir harus berupa tanggal yang valid.',
            'periode_akhir.after_or_equal' => 'Periode akhir harus sama dengan atau setelah periode awal.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus dibuka atau ditutup.',
        ];
    }
}
