<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Administrator;
use App\Models\Commissioner;
use App\Models\ScholarshipCall;
use App\Models\Application;
use App\Models\Contract;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $call = ScholarshipCall::factory()->create();

        University::factory()
            ->count(2)
            ->has(
                Faculty::factory()
                    ->count(3)
                    ->has(
                        Administrator::factory()->count(2)
                    )
                    ->has(
                        Student::factory()
                            ->count(20)
                            ->has(
                                Contract::factory()->state([
                                    'scholarship_call_id' => $call->id
                                ])
                            )
                    )
            )
            ->create();

        Commissioner::factory()->count(5)->create();

        Student::all()->each(function ($student) use ($call) {
            Application::factory()->create([
                'student_id' => $student->id,
                'scholarship_call_id' => $call->id,
            ]);
        });
    }
}