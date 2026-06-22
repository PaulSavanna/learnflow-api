<?php

namespace Tests\Feature;

use App\Domain\Models\User;
use App\Domain\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VacancyApiTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRecruiter(): User
    {
        $user = User::factory()->create(['role' => 'recruiter']);
        $this->actingAs($user);
        return $user;
    }

    public function test_can_list_vacancies(): void
    {
        $this->actingAsRecruiter();
        Vacancy::factory()->count(3)->create();
        $response = $this->getJson('/api/vacancies');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_create_vacancy(): void
    {
        $this->actingAsRecruiter();
        $response = $this->postJson('/api/vacancies', ['title' => 'PHP Dev', 'description' => 'Senior PHP developer']);
        $response->assertCreated()->assertJsonStructure(['data' => ['id', 'title', 'description']]);
    }

    public function test_can_show_vacancy(): void
    {
        $this->actingAsRecruiter();
        $vacancy = Vacancy::factory()->create();
        $response = $this->getJson("/api/vacancies/{$vacancy->id}");
        $response->assertOk()->assertJsonPath('data.id', $vacancy->id);
    }

    public function test_unauthenticated_cannot_access(): void
    {
        $response = $this->getJson('/api/vacancies');
        $response->assertUnauthorized();
    }
}
