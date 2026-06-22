<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration_hours'];

    protected static function newFactory(): CourseFactory
    {
        return CourseFactory::new();
    }

    public function assignments()
    {
        return $this->hasMany(CourseAssignment::class);
    }
}
