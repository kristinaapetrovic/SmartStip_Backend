<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'year_of_study' => [
                'required',
                'string',
                'max:10',
            ],
            'type_of_study' => [
                'required',
                'in:' . implode(',', \App\Models\Student::$types_of_study),
            ],
            'average_grade' => [
                'required',
                'numeric',
                'between:0,10',
            ],
            'field_of_study' => [
                'required',
                'string',
                'max:255',
            ],
            'index_number' => [
                'required',
                'string',
                'max:50',
                'unique:students,index_number',
            ],
            'street_address' => [
                'required',
                'string',
                'max:255',
            ],
            'phone_number' => [
                'required',
                'string',
                'max:20',
            ],
            'user_id' => [
                'required',
                'exists:users,id',
                'unique:students,user_id', 
            ],
            'location_id' => [
                'required',
                'exists:locations,id',
            ],
            'faculty_id' => [
                'required',
                'exists:faculties,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'year_of_study.required' => 'Year of study is required.',
            'year_of_study.string' => 'Year of study must be a string.',
            'year_of_study.max' => 'Year of study is too long.',

            'type_of_study.required' => 'Type of study is required.',
            'type_of_study.in' => 'Invalid type of study.',

            'average_grade.required' => 'Average grade is required.',
            'average_grade.numeric' => 'Average grade must be a number.',
            'average_grade.between' => 'Average grade must be between 0 and 10.',

            'field_of_study.required' => 'Field of study is required.',
            'field_of_study.string' => 'Field of study must be a string.',
            'field_of_study.max' => 'Field of study is too long.',

            'index_number.required' => 'Index number is required.',
            'index_number.string' => 'Index number must be a string.',
            'index_number.max' => 'Index number is too long.',
            'index_number.unique' => 'This index number is already taken.',

            'street_address.required' => 'Street address is required.',
            'street_address.string' => 'Street address must be a string.',
            'street_address.max' => 'Street address is too long.',

            'phone_number.required' => 'Phone number is required.',
            'phone_number.string' => 'Phone number must be a string.',
            'phone_number.max' => 'Phone number is too long.',

            'user_id.required' => 'User is required.',
            'user_id.exists' => 'Selected user does not exist.',
            'user_id.unique' => 'This user is already a student.',

            'location_id.required' => 'Location is required.',
            'location_id.exists' => 'Selected location does not exist.',

            'faculty_id.required' => 'Faculty is required.',
            'faculty_id.exists' => 'Selected faculty does not exist.',
        ];
    }
}
