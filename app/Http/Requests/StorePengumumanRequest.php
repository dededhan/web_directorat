<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengumumanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'judul_pengumuman' => 'required|string|max:50',
            'icon' => 'nullable|string',
            'isi_pengumuman' => 'required|string|max:200',
        ];
    }
}
