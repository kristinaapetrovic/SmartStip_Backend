<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $student = $this->route('student');
        return $this->user()->can('update', $student);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'year_of_study' => ['required','string','max:10'],
            'type_of_study' => ['required','in:' . implode(',', \App\Models\Student::$types_of_study)],
            'average_grade' => ['required','numeric','between:0,10'],
            'field_of_study' => ['required','string','max:255'],
            'index_number' => [
                'required','string','max:50'
            ],
            'street_address' => ['required','string','max:255'],
            'phone_number' => ['required','string','max:20'],
            'user_id' => [
                'required','exists:users,id'
            ],
            'location_id' => ['required','exists:locations,id'],
            'faculty_id' => ['required','exists:faculties,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'year_of_study.required' => 'Year of study is required.',
            'type_of_study.in' => 'Invalid type of study.',
            'average_grade.between' => 'Average grade must be between 0 and 10.',
            'index_number.unique' => 'This index number is already taken.',
            'user_id.unique' => 'This user is already a student.',
            'location_id.exists' => 'Selected location does not exist.',
            'faculty_id.exists' => 'Selected faculty does not exist.',
        ];
    }
}
