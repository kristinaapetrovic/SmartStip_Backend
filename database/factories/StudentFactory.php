<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\User;
use App\Models\Location;
use App\Models\Faculty;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'year_of_study' => $this->faker->numberBetween(1, 5),

            'type_of_study' => $this->faker->randomElement(Student::$types_of_study),

            'average_grade' => $this->faker->randomFloat(2, 6, 10),

            'field_of_study' => $this->faker->randomElement([
                'Computer Science',
                'Engineering',
                'Economics',
                'Law',
                'Medicine',
            ]),

            'index_number' => $this->faker->unique()->numerify('20######'),

            'street_address' => $this->faker->streetAddress(),

            'phone_number' => $this->faker->phoneNumber(),

            'user_id' => User::factory(),

            'location_id' => Location::factory(),

            'faculty_id' => Faculty::factory(),
        ];
    }
}
