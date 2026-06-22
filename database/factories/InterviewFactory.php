<?php

namespace Database\Factories;

use App\Domain\Models\Candidate;
use App\Domain\Models\Interview;
use App\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    protected $model = Interview::class;
    public function definition(): array
    {
        return [
            'candidate_id' => Candidate::factory(),
            'interviewer_id' => User::factory(),
            'scheduled_at' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'result' => 'pending',
            'notes' => null,
        ];
    }
}
