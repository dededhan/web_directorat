<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukInovasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assuming you're using middleware for authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => 'required|string|max:1500',
            'inovator' => 'required|string|max:1500',
            'deskripsi' => 'required|string|max:1500',
            'nomor_paten' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.max' => 'Nama produk maksimal 1500 karakter',
            'inovator.required' => 'Nama inovator harus diisi',
            'inovator.max' => 'Nama inovator maksimal 1500 karakter',
            'deskripsi.required' => 'Deskripsi produk harus diisi',
            'deskripsi.max' => 'Deskripsi maksimal 1500 karakter',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}