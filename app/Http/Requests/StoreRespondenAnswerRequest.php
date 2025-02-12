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
        $this->request->add(['email' => $this->input('answer_email')]);
        $this->request->remove('answer_email');
        $this->request->add(['phone' => $this->input('answer_phone')]);
        $this->request->remove('answer_phone');
        return [
            'answer_title' => ['required'],
            'answer_firstname' => ['required'],
            'answer_lastname' => ['required'],
            'answer_job_title' => ['required'],
            'answer_institution' => ['required'],
            'answer_company' => ['required'],
            'answer_country' => ['required'],
            'email' => ['required', 'email:rfc', 'unique:responden_answers'],
            'phone' => ['required', 'unique:responden_answers'],
            'answer_survey_2023' => ['required'],
            'answer_survey_2024' => ['required']
        ];
    }
}
