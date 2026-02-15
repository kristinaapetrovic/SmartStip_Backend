<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Location;
use App\Models\University;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\University>
 */
class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = University::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' University',
            'location_id' => Location::factory(),
        ];
    }
}
