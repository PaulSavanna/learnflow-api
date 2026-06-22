<?php

namespace App\Domain\Models;

use App\Domain\Enums\CandidateStatus;
use App\Domain\Exceptions\InvalidStatusTransition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CandidateFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'vacancy_id', 'status'];

    protected static function newFactory(): CandidateFactory
    {
        return CandidateFactory::new();
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function getStatus(): CandidateStatus
    {
        return CandidateStatus::from($this->status);
    }

    public function transitionTo(CandidateStatus $newStatus): void
    {
        $current = $this->getStatus();
        if (!$current->canTransitionTo($newStatus)) {
            throw InvalidStatusTransition::between($current, $newStatus);
        }
        $this->update(['status' => $newStatus->value]);
    }
}
