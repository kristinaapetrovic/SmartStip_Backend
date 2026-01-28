<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'sometimes',
                'in:' . implode(',', \App\Models\Application::$statuses),
            ],

            'average_grade_url' => [
                'required',
                'string',
                'max:255',
            ],

            'espb_url' => [
                'required',
                'string',
                'max:255',
            ],

            'identification_card_url' => [
                'required',
                'string',
                'max:255',
            ],

            'proof_of_unenrollment_url' => [
                'required',
                'string',
                'max:255',
            ],

            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'scholarship_call_id' => [
                'required',
                'exists:scholarship_calls,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Invalid application status.',

            'average_grade_url.required' => 'Average grade document is required.',
            'average_grade_url.max' => 'Average grade document URL is too long.',

            'espb_url.required' => 'ESPB document is required.',
            'espb_url.max' => 'ESPB document URL is too long.',

            'identification_card_url.required' => 'Identification card document is required.',
            'identification_card_url.max' => 'Identification card URL is too long.',

            'proof_of_unenrollment_url.required' => 'Proof of unenrollment is required.',
            'proof_of_unenrollment_url.max' => 'Proof of unenrollment URL is too long.',

            'student_id.required' => 'Student is required.',
            'student_id.exists' => 'Selected student does not exist.',

            'scholarship_call_id.required' => 'Scholarship call is required.',
            'scholarship_call_id.exists' => 'Selected scholarship call does not exist.',
        ];
    }
}
