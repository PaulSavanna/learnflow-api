<?php

namespace App\Application\Services;

use App\Domain\Enums\CandidateStatus;
use App\Domain\Models\ActivityLog;
use App\Domain\Models\Candidate;
use App\Domain\Repositories\CandidateRepositoryInterface;
use Illuminate\Support\Collection;

class CandidateService
{
    public function __construct(
        private CandidateRepositoryInterface $candidates,
    ) {}

    public function createCandidate(array $data): Candidate
    {
        $data['status'] = CandidateStatus::New->value;
        return $this->candidates->create($data);
    }

    public function getCandidate(int $id): ?Candidate
    {
        return $this->candidates->findById($id);
    }

    public function updateStatus(int $id, CandidateStatus $newStatus, int $userId): Candidate
    {
        $candidate = $this->candidates->findById($id);
        $oldStatus = $candidate->getStatus();
        $candidate->transitionTo($newStatus);

        ActivityLog::create([
            'candidate_id' => $candidate->id,
            'user_id' => $userId,
            'action' => 'status_changed',
            'details' => ['from' => $oldStatus->value, 'to' => $newStatus->value],
        ]);

        return $candidate->fresh('vacancy');
    }

    public function listCandidates(): Collection
    {
        return $this->candidates->all();
    }
}
