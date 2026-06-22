<?php

namespace App\Providers;

use App\Application\Services\CandidateService;
use App\Application\Services\VacancyService;
use App\Domain\Repositories\CandidateRepositoryInterface;
use App\Domain\Repositories\VacancyRepositoryInterface;
use App\Infrastructure\Repositories\EloquentCandidateRepository;
use App\Infrastructure\Repositories\EloquentVacancyRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CandidateRepositoryInterface::class, EloquentCandidateRepository::class);
        $this->app->bind(VacancyRepositoryInterface::class, EloquentVacancyRepository::class);
        $this->app->singleton(CandidateService::class);
        $this->app->singleton(VacancyService::class);
    }
}
