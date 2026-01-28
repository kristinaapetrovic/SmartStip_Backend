<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniversityRequest extends FormRequest
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
                'unique:universities,name', 
            ],
            'location_id' => [
                'required',
                'exists:locations,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'University name is required.',
            'name.string' => 'University name must be a string.',
            'name.max' => 'University name is too long.',
            'name.unique' => 'A university with this name already exists.',

            'location_id.required' => 'Location is required.',
            'location_id.exists' => 'Selected location does not exist.',
        ];
    }
}
