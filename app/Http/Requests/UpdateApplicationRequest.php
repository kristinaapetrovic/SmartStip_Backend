<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $application = $this->route('application');
        return Gate::allows('update', $application);
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
                'sometimes',
                'string',
                'max:255',
            ],
            'espb_url' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'identification_card_url' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'proof_of_unenrollment_url' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'scholarship_call_id' => [
                'sometimes',
                'exists:scholarship_calls,id',
            ],
            'student_id' => [
                'sometimes',
                'exists:students,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Invalid application status.',
            'average_grade_url.max' => 'Average grade URL is too long.',
            'espb_url.max' => 'ESPB URL is too long.',
            'identification_card_url.max' => 'Identification card URL is too long.',
            'proof_of_unenrollment_url.max' => 'Proof of unenrollment URL is too long.',
            'scholarship_call_id.exists' => 'Selected scholarship call does not exist.',
            'student_id.exists' => 'Selected student does not exist.',
        ];
    }
}
