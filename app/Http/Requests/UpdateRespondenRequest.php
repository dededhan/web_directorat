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
        // 2. Get the respondent's ID from the route parameter.
        // This name ('id') must match the parameter name in your routes/web.php file.
        $respondenId = $this->route('responden');

        return [
            'title' => 'required|string|max:10',
            'fullname' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',

            // 3. Update the email validation rule
            'email' => [
                'required',
                'email',
                Rule::unique('respondens')->ignore($respondenId),
            ],

            // 4. Update the phone_responden validation rule
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