<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacultyRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:faculties,name', 
            ],
            'street_address' => [
                'required',
                'string',
                'max:255',
            ],
            'location_id' => [
                'required',
                'exists:locations,id',
            ],
            'university_id' => [
                'required',
                'exists:universities,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Faculty name is required.',
            'name.string' => 'Faculty name must be a string.',
            'name.max' => 'Faculty name is too long.',
            'name.unique' => 'A faculty with this name already exists.',

            'street_address.required' => 'Street address is required.',
            'street_address.string' => 'Street address must be a string.',
            'street_address.max' => 'Street address is too long.',

            'location_id.required' => 'Location is required.',
            'location_id.exists' => 'Selected location does not exist.',

            'university_id.required' => 'University is required.',
            'university_id.exists' => 'Selected university does not exist.',
        ];
    }
}
