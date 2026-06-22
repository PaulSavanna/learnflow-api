<?php

namespace Database\Factories;

use App\Domain\Models\Course;
use App\Domain\Models\CourseAssignment;
use App\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Models\Candidate;

class CourseAssignmentFactory extends Factory
{
    protected $model = CourseAssignment::class;
    public function definition(): array
    {
        return [
            'candidate_id' => Candidate::factory(),
            'course_id' => Course::factory(),
            'progress' => 0,
            'assigned_by' => User::factory(),
        ];
    }
}
