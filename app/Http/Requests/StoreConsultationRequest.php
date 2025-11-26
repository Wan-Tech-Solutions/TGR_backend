<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
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
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'dial_code' => ['required', 'string', 'max:10'],
            'client_phone' => ['required', 'string', 'regex:/^\d{9}$/'],
            'client_nationality' => ['nullable', 'string', 'max:255'],
            'country_of_residence' => ['required', 'string', 'max:255'],
            'consultation_hours' => ['required', 'integer', 'min:1', 'max:4'],
            'selected_date' => ['required', 'date', 'after_or_equal:today'],
            'questionnaire' => ['required', 'array', 'size:34'],
            'questionnaire.*' => ['required', 'integer', 'min:1', 'max:10'],
            'rebook_of' => ['nullable', 'uuid'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'client_name.required' => 'Please provide your full name.',
            'client_email.required' => 'Please provide your email address.',
            'client_email.email' => 'Please provide a valid email address.',
            'client_phone.regex' => 'Please provide a valid 9-digit phone number.',
            'country_of_residence.required' => 'Please select your country of residence.',
            'consultation_hours.required' => 'Please select the number of consultation hours.',
            'consultation_hours.min' => 'You must request at least 1 hour.',
            'consultation_hours.max' => 'You can request a maximum of 4 hours.',
            'selected_date.required' => 'Please select a consultation date.',
            'selected_date.after_or_equal' => 'You must select a date that is today or in the future.',
            'questionnaire.required' => 'Please complete all assessment questions.',
            'questionnaire.size' => 'You must answer all 34 assessment questions.',
            'questionnaire.*.required' => 'All assessment questions must be answered.',
            'questionnaire.*.integer' => 'Assessment responses must be whole numbers.',
            'questionnaire.*.min' => 'Assessment responses must be between 1 and 10.',
            'questionnaire.*.max' => 'Assessment responses must be between 1 and 10.',
        ];
    }
}

