<?php

namespace Database\Factories;

use App\Domain\Models\Candidate;
use App\Domain\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateFactory extends Factory
{
    protected $model = Candidate::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'vacancy_id' => Vacancy::factory(),
            'status' => 'new',
        ];
    }
}
