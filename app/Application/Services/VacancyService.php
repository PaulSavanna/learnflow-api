<?php

namespace App\Application\Services;

use App\Domain\Models\Vacancy;
use App\Domain\Repositories\VacancyRepositoryInterface;
use Illuminate\Support\Collection;

class VacancyService
{
    public function __construct(
        private VacancyRepositoryInterface $vacancies,
    ) {}

    public function createVacancy(array $data): Vacancy
    {
        return $this->vacancies->create($data);
    }

    public function getVacancy(int $id): ?Vacancy
    {
        return $this->vacancies->findById($id);
    }

    public function listVacancies(): Collection
    {
        return $this->vacancies->all();
    }
}
