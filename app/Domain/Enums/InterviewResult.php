<?php

namespace App\Domain\Enums;

enum InterviewResult: string
{
    case Pending = 'pending';
    case Passed = 'passed';
    case Failed = 'failed';
}
