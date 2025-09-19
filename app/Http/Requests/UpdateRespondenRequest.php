<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- 1. Import the Rule class

class UpdateRespondenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Or your specific authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $respondenId = $this->route('responden')->id;

        return [
            'title' => 'required|string|max:10',
            'fullname' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('respondens')->ignore($respondenId),
            ],

            'phone_responden' => [
                'nullable',
                'string',
                Rule::unique('respondens')->ignore($respondenId),
            ],

            'nama_dosen_pengusul' => 'required|string|max:255',
            'phone_dosen' => 'required|string|max:255',
            'fakultas' => 'required|string',
            'category' => 'required|string|in:academic,employer',
        ];
    }
}