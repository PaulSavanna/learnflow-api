<?php

namespace App\Http\Controllers;

use App\Application\Services\VacancyService;
use App\Http\Resources\VacancyResource;

class VacancyController extends Controller
{
    public function __construct(
        private VacancyService $vacancyService,
    ) {}

    public function index()
    {
        return VacancyResource::collection($this->vacancyService->listVacancies());
    }

    public function store(\App\Http\Requests\StoreVacancyRequest $request)
    {
        $vacancy = $this->vacancyService->createVacancy(
            array_merge($request->validated(), ['created_by' => $request->user()->id])
        );
        return new VacancyResource($vacancy);
    }

    public function show(int $id)
    {
        $vacancy = $this->vacancyService->getVacancy($id);
        if (!$vacancy) {
            return response()->json(['message' => 'Vacancy not found'], 404);
        }
        return new VacancyResource($vacancy);
    }
}
