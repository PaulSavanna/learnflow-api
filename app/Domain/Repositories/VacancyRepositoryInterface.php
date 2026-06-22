<?php

namespace App\Domain\Repositories;

use App\Domain\Models\Vacancy;
use Illuminate\Support\Collection;

interface VacancyRepositoryInterface
{
    public function findById(int $id): ?Vacancy;
    public function create(array $data): Vacancy;
    public function all(): Collection;
}
