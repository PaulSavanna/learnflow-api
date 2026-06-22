<?php

namespace App\Domain\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Recruiter = 'recruiter';
    case Mentor = 'mentor';
}
