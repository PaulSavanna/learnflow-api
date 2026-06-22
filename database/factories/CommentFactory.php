<?php

namespace Database\Factories;

use App\Domain\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;
    public function definition(): array
    {
        return [
            'candidate_id' => \App\Domain\Models\Candidate::factory(),
            'user_id' => \App\Domain\Models\User::factory(),
            'body' => fake()->sentence(),
        ];
    }
}
