<?php

namespace Database\Factories;

use App\Domain\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'duration_hours' => fake()->numberBetween(1, 40),
        ];
    }
}
