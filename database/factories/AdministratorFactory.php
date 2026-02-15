<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Administrator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrator>
 */
class AdministratorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Administrator::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'faculty_id' => Faculty::factory(),
        ];
    }
}
