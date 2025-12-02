<?php

namespace App\Http\Requests\StudentExchange;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubChapterStudentExchangeRequest extends FormRequest
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
            'judul_sub_chapter' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_input' => 'required|in:pdf,link,pdf_atau_link',
            'is_wajib' => 'required|boolean',
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
            'judul_sub_chapter.required' => 'Judul sub chapter wajib diisi.',
            'judul_sub_chapter.max' => 'Judul sub chapter maksimal 255 karakter.',
            'tipe_input.required' => 'Tipe input wajib dipilih.',
            'tipe_input.in' => 'Tipe input harus pdf, link, atau pdf_atau_link.',
            'is_wajib.required' => 'Status wajib harus dipilih.',
            'is_wajib.boolean' => 'Status wajib harus berupa true atau false.',
            'urutan.required' => 'Urutan wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal 1.',
        ];
    }
}
