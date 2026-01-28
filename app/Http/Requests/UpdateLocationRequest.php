<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $location = $this->route('location');
        return Gate::allows('update', $location);
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
                'max:255'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Location name is required.',
            'name.string' => 'Location name must be a string.',
            'name.max' => 'Location name is too long.',
            'name.unique' => 'A location with this name already exists.',
        ];
    }
}
