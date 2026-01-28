<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
            'type' => [
                'required',
                'in:' . implode(',', \App\Models\Contract::$types),
            ],
            'contract_date' => [
                'required',
                'date',
            ],
            'signed' => [
                'required',
                'boolean',
            ],
            'terminated' => [
                'required',
                'boolean',
            ],
            'details' => [
                'nullable',
                'string',
            ],
            'student_id' => [
                'required',
                'exists:students,id',
                'unique:contracts,student_id', 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Contract type is required.',
            'type.in' => 'Invalid contract type.',

            'contract_date.required' => 'Contract date is required.',
            'contract_date.date' => 'Contract date must be a valid date.',

            'signed.required' => 'Signed status is required.',
            'signed.boolean' => 'Signed must be true or false.',

            'terminated.required' => 'Terminated status is required.',
            'terminated.boolean' => 'Terminated must be true or false.',

            'details.string' => 'Details must be text.',

            'student_id.required' => 'Student is required.',
            'student_id.exists' => 'Selected student does not exist.',
            'student_id.unique' => 'This student already has a contract.',
        ];
    }
}
