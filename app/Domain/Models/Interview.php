<?php

namespace App\Domain\Models;

use App\Domain\Enums\InterviewResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\InterviewFactory;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'interviewer_id', 'scheduled_at', 'result', 'notes'];
    protected $casts = ['scheduled_at' => 'datetime'];

    protected static function newFactory(): InterviewFactory
    {
        return InterviewFactory::new();
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewer_id');
    }

    public function getResult(): InterviewResult
    {
        return InterviewResult::from($this->result);
    }
}
