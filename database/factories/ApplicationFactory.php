<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Application;
use App\Models\Student;
use App\Models\ScholarshipCall;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(Application::$statuses);

        return [
            'status' => $status,

            'reason_for_rejection' => $status === 'rejected'
                ? $this->faker->sentence()
                : null,

            'average_grade_url' => $this->faker->url(),
            'espb_url' => $this->faker->url(),
            'identification_card_url' => $this->faker->url(),
            'proof_of_unenrollment_url' => $this->faker->url(),

            'student_id' => Student::factory(),
            'scholarship_call_id' => ScholarshipCall::factory(),
        ];
    }
}