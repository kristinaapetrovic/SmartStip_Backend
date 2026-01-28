<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScholarshipCallRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:scholarship_calls,title', // jedinstven naslov konkursa
            ],
            'description' => [
                'required',
                'string',
            ],
            'status' => [
                'sometimes',
                'in:' . implode(',', \App\Models\ScholarshipCall::$statuses),
            ],
            'application_deadline' => [
                'required',
                'date',
                'after_or_equal:today', 
            ],
            'complaint_deadline' => [
                'nullable',
                'date',
                'after:application_deadline', 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a string.',
            'title.max' => 'Title is too long.',
            'title.unique' => 'A scholarship call with this title already exists.',

            'description.required' => 'Description is required.',
            'description.string' => 'Description must be text.',

            'status.in' => 'Invalid status.',

            'application_deadline.required' => 'Application deadline is required.',
            'application_deadline.date' => 'Application deadline must be a valid date.',
            'application_deadline.after_or_equal' => 'Application deadline cannot be in the past.',

            'complaint_deadline.date' => 'Complaint deadline must be a valid date.',
            'complaint_deadline.after' => 'Complaint deadline must be after the application deadline.',
        ];
    }
}
