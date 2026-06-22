<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Candidate;
use App\Domain\Repositories\CandidateRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentCandidateRepository implements CandidateRepositoryInterface
{
    public function findById(int $id): ?Candidate
    {
        return Candidate::find($id);
    }

    public function create(array $data): Candidate
    {
        return Candidate::create($data);
    }

    public function save(Candidate $candidate): void
    {
        $candidate->save();
    }

    public function all(): Collection
    {
        return Candidate::with('vacancy')->get();
    }
}
