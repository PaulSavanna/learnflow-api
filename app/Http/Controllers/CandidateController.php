<?php

namespace App\Http\Controllers;

use App\Application\Services\CandidateService;
use App\Domain\Enums\CandidateStatus;
use App\Http\Resources\CandidateResource;

class CandidateController extends Controller
{
    public function __construct(
        private CandidateService $candidateService,
    ) {}

    public function index()
    {
        return CandidateResource::collection($this->candidateService->listCandidates());
    }

    public function store(\App\Http\Requests\StoreCandidateRequest $request)
    {
        $candidate = $this->candidateService->createCandidate($request->validated());
        return new CandidateResource($candidate);
    }

    public function show(int $id)
    {
        $candidate = $this->candidateService->getCandidate($id);
        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }
        return new CandidateResource($candidate);
    }

    public function updateStatus(\App\Http\Requests\UpdateCandidateStatusRequest $request, int $id)
    {
        $candidate = $this->candidateService->updateStatus(
            $id,
            CandidateStatus::from($request->input('status')),
            $request->user()->id
        );
        return new CandidateResource($candidate);
    }
}
