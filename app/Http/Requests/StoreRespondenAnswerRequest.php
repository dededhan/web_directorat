<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespondenAnswerRequest extends FormRequest
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
            'answer_title' => ['required', 'string', 'max:10'],
            'answer_firstname' => ['required', 'string', 'max:255'],
            'answer_lastname' => ['required', 'string', 'max:255'],
            'answer_job_title' => ['required', 'string', 'max:255'],
            'answer_institution' => ['required', 'string', 'max:255'],
            'answer_company' => ['required', 'string', 'max:255'],
            'answer_country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'unique:responden_answers,email'],
            'answer_phone' => ['required', 'string', 'unique:responden_answers,phone'],
            'answer_survey_2023' => ['required', 'in:yes,no'],
            'answer_survey_2024' => ['required', 'in:yes,no'],
            'token' => ['required', 'string', 'exists:respondens,token'],
        ];
    }
}
