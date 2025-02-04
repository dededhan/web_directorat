<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuesionerGeneralRequest extends FormRequest
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
        $this->request->add(['email' => $this->input('general_email')]);
        $this->request->add(['phone' => $this->input('general_phone')]);
        $this->request->remove('general_phone');
        $this->request->remove('general_email');
        // $this->dd($this->request->all());
        return [
            'general_respondent_type' => ['required'],
            'general_firstname' => ['required'],
            'general_lastname' => ['required'],
            'general_institution' => ['required'],
            'general_activity_name' => ['required'],
            'general_activity_date' => ['required'],
            'general_country' => ['required'],
            'email' => ['required', 'email:rfc', 'unique:quesioner_generals'],
            'phone' => ['required', 'unique:quesioner_generals'],
            'general_survey2023' => ['required'],
            'general_survey2024' => ['required'],
        ];
    }
}
