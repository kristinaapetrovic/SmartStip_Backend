<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Commissioner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commissioner>
 */
class CommissionerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Commissioner::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
