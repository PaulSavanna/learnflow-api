<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CourseAssignmentFactory;

class CourseAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'course_id', 'progress', 'assigned_by'];
    protected $casts = ['progress' => 'integer'];

    protected static function newFactory(): CourseAssignmentFactory
    {
        return CourseAssignmentFactory::new();
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function isCompleted(): bool
    {
        return $this->progress >= 100;
    }
}
