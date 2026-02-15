<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ScholarshipCall;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScholarshipCall>
 */
class ScholarshipCallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ScholarshipCall::class;

    public function definition(): array
    {
        $applicationDeadline = $this->faker->dateTimeBetween('now', '+3 months');

        return [
            'title' => 'Scholarship for ' . $this->faker->randomElement([
                'IT Students',
                'Engineering',
                'Master Studies',
                'PhD Candidates',
                'Outstanding Students'
            ]),

            'description' => $this->faker->paragraphs(3, true),

            'status' => $this->faker->randomElement(ScholarshipCall::$statuses),

            'application_deadline' => $applicationDeadline,

            'complaint_deadline' => $this->faker->optional()->dateTimeBetween(
                $applicationDeadline,
                '+1 month'
            ),
        ];
    }
}
