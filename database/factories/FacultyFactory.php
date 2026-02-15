<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Faculty;
use App\Models\University;
use App\Models\Location;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Faculty::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Faculty of Engineering',
                'Faculty of Law',
                'Faculty of Medicine',
                'Faculty of Economics',
                'Faculty of Computer Science',
            ]),

            'street_address' => $this->faker->streetAddress(),

            'location_id' => Location::factory(),

            'university_id' => University::factory(),
        ];
    }
}
