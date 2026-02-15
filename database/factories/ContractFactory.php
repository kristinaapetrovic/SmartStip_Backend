<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contract;
use App\Models\Student;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $contractDate = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'type' => $this->faker->randomElement(Contract::$types),

            'contract_date' => $contractDate,

            'signed' => $this->faker->boolean(80), // 80% signed

            'terminated' => $this->faker->boolean(10), // 10% terminated

            'details' => $this->faker->optional()->paragraph(),

            'student_id' => Student::factory(),
        ];
    }
}
