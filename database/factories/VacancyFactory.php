<?php

namespace Database\Factories;

use App\Domain\Models\User;
use App\Domain\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    protected $model = Vacancy::class;
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'created_by' => User::factory(),
        ];
    }
}
