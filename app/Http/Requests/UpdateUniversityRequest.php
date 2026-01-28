<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $university = $this->route('university');
        return $this->user()->can('update', $university);
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
                'required','string','max:255',
            ],
            'location_id' => ['required','exists:locations,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'University name is required.',
            'name.unique' => 'A university with this name already exists.',
            'location_id.required' => 'Location is required.',
            'location_id.exists' => 'Selected location does not exist.',
        ];
    }
}
