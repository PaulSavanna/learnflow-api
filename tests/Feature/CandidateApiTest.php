<?php

namespace Tests\Feature;

use App\Domain\Enums\CandidateStatus;
use App\Domain\Models\Candidate;
use App\Domain\Models\User;
use App\Domain\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateApiTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRecruiter(): User
    {
        $user = User::factory()->create(['role' => 'recruiter']);
        $this->actingAs($user);
        return $user;
    }

    public function test_can_list_candidates(): void
    {
        $this->actingAsRecruiter();
        Candidate::factory()->count(3)->create();
        $response = $this->getJson('/api/candidates');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_create_candidate(): void
    {
        $this->actingAsRecruiter();
        $vacancy = Vacancy::factory()->create();
        $response = $this->postJson('/api/candidates', ['name' => 'John', 'email' => 'john@test.com', 'vacancy_id' => $vacancy->id]);
        $response->assertCreated()->assertJsonPath('data.status', 'new');
    }

    public function test_can_update_candidate_status(): void
    {
        $this->actingAsRecruiter();
        $candidate = Candidate::factory()->create(['status' => CandidateStatus::New->value]);
        $response = $this->patchJson("/api/candidates/{$candidate->id}/status", ['status' => CandidateStatus::Screening->value]);
        $response->assertOk()->assertJsonPath('data.status', CandidateStatus::Screening->value);
    }

    public function test_invalid_status_transition_returns_422(): void
    {
        $this->actingAsRecruiter();
        $candidate = Candidate::factory()->create(['status' => CandidateStatus::New->value]);
        $response = $this->patchJson("/api/candidates/{$candidate->id}/status", ['status' => CandidateStatus::Hired->value]);
        $response->assertUnprocessable();
    }

    public function test_status_change_logged(): void
    {
        $this->actingAsRecruiter();
        $candidate = Candidate::factory()->create(['status' => CandidateStatus::New->value]);
        $this->patchJson("/api/candidates/{$candidate->id}/status", ['status' => CandidateStatus::Screening->value]);
        $this->assertDatabaseHas('activity_logs', ['candidate_id' => $candidate->id, 'action' => 'status_changed']);
    }
}
