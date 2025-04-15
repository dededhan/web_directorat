<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
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
     */
    public function rules()
    {
        return [
            'kategori' => 'required|in:inovasi,pemeringkatan,umum',
            'tanggal' => 'required|date',
            'judul_berita' => 'required|string|max:200',
            'isi_berita' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images' => 'nullable|array|max:3',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    /**
     * Custom attribute names for validation messages.
     */
    public function attributes()
    {
        return [
            'judul_berita' => 'judul berita',
            'isi_berita' => 'isi berita',
            'gambar' => 'gambar berita'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages()
    {
        return [
            'kategori.required' => 'Kategori berita wajib dipilih',
            'kategori.in' => 'Kategori berita tidak valid',
            'tanggal.required' => 'Tanggal berita wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'gambar.required' => 'Gambar berita wajib diunggah',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, atau jpg',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
            'additional_images.max' => 'Maksimal 3 gambar tambahan',
            'additional_images.*.image' => 'File harus berupa gambar',
            'additional_images.*.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'additional_images.*.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}