<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespondenRequest extends FormRequest
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
            'responden_title' => ['required'],
            'responden_fullname' => ['required'],
            'responden_jabatan' => ['required'],
            'responden_instansi' => ['required'],
            'email' => ['required', 'unique:respondens', 'email:rfc'],
            'phone_responden' => ['required', 'unique:respondens'],
            'responden_dosen' => ['required'],
            'responden_dosen_phone' => ['required'],
            'responden_fakultas' => ['required'],
            'responden_category' => ['required'],
        ];
    }

    public function message(){
        // custom message validation
    }
}
