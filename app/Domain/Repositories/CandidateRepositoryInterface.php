<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Candidate;
use Illuminate\Support\Collection;

interface CandidateRepositoryInterface
{
    public function findById(int $id): ?Candidate;
    public function create(array $data): Candidate;
    public function save(Candidate $candidate): void;
    public function all(): Collection;
}
