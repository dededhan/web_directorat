<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramLayananRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'icon' => 'required|string',
            'judul' => 'required|string|max:50',
            'deskripsi' => 'required|string|max:500',
        ];
    }
}