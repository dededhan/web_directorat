<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePimpinanRequest extends FormRequest
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
            'jabatan' => 'required|in:Direktur Inovasi Sistem Informasi dan Pemeringkatan,Kepala Subdirektorat Inovasi dan Hilirisai,Kepala Subdirektorat Sistem Informasi dan Pemeringkatan',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:8192',
        ];
    }
}