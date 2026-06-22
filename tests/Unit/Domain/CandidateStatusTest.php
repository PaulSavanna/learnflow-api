<?php

namespace Tests\Unit\Domain;

use App\Domain\Enums\CandidateStatus;
use PHPUnit\Framework\TestCase;

class CandidateStatusTest extends TestCase
{
    public function test_new_can_transition_to_screening(): void { $this->assertTrue(CandidateStatus::New->canTransitionTo(CandidateStatus::Screening)); }
    public function test_new_can_transition_to_rejected(): void { $this->assertTrue(CandidateStatus::New->canTransitionTo(CandidateStatus::Rejected)); }
    public function test_new_cannot_transition_to_hired(): void { $this->assertFalse(CandidateStatus::New->canTransitionTo(CandidateStatus::Hired)); }
    public function test_screening_can_transition_to_learning(): void { $this->assertTrue(CandidateStatus::Screening->canTransitionTo(CandidateStatus::Learning)); }
    public function test_learning_can_transition_to_test_task(): void { $this->assertTrue(CandidateStatus::Learning->canTransitionTo(CandidateStatus::TestTask)); }
    public function test_test_task_can_transition_to_ready(): void { $this->assertTrue(CandidateStatus::TestTask->canTransitionTo(CandidateStatus::ReadyForInterview)); }
    public function test_ready_can_transition_to_interview(): void { $this->assertTrue(CandidateStatus::ReadyForInterview->canTransitionTo(CandidateStatus::Interview)); }
    public function test_interview_can_transition_to_hired(): void { $this->assertTrue(CandidateStatus::Interview->canTransitionTo(CandidateStatus::Hired)); }
    public function test_hired_cannot_transition(): void { $this->assertEmpty(CandidateStatus::Hired->allowedTransitions()); }
    public function test_rejected_cannot_transition(): void { $this->assertEmpty(CandidateStatus::Rejected->allowedTransitions()); }
}
