<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $contract = $this->route('contract');
        return \Gate::allows('update', $contract);
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
                'sometimes',
                'in:' . implode(',', \App\Models\Contract::$types),
            ],
            'contract_date' => [
                'sometimes',
                'date',
            ],
            'signed' => [
                'sometimes',
                'boolean',
            ],
            'terminated' => [
                'sometimes',
                'boolean',
            ],
            'details' => [
                'nullable',
                'string',
            ],
            'student_id' => [
                'sometimes',
                'exists:students,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'Invalid contract type.',
            'contract_date.date' => 'Contract date must be a valid date.',
            'signed.boolean' => 'Signed must be true or false.',
            'terminated.boolean' => 'Terminated must be true or false.',
            'details.string' => 'Details must be text.',
            'student_id.exists' => 'Selected student does not exist.',
            'student_id.unique' => 'This student already has a contract.',
        ];
    }
}
