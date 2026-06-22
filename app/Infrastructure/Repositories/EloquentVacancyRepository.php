<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Vacancy;
use App\Domain\Repositories\VacancyRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentVacancyRepository implements VacancyRepositoryInterface
{
    public function findById(int $id): ?Vacancy
    {
        return Vacancy::find($id);
    }

    public function create(array $data): Vacancy
    {
        return Vacancy::create($data);
    }

    public function all(): Collection
    {
        return Vacancy::all();
    }
}
