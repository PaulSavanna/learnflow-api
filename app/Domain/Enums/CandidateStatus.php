<?php

namespace App\Domain\Enums;

enum CandidateStatus: string
{
    case New = 'new';
    case Screening = 'screening';
    case Learning = 'learning';
    case TestTask = 'test_task';
    case ReadyForInterview = 'ready_for_interview';
    case Interview = 'interview';
    case Hired = 'hired';
    case Rejected = 'rejected';

    public function allowedTransitions(): array
    {
        return match ($this) {
            self::New => [self::Screening, self::Rejected],
            self::Screening => [self::Learning, self::Rejected],
            self::Learning => [self::TestTask, self::Rejected],
            self::TestTask => [self::ReadyForInterview, self::Rejected],
            self::ReadyForInterview => [self::Interview, self::Rejected],
            self::Interview => [self::Hired, self::Rejected],
            self::Hired => [],
            self::Rejected => [],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }
}
