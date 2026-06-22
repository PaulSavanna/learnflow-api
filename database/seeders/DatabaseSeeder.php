<?php

namespace Database\Seeders;

use App\Domain\Enums\UserRole;
use App\Domain\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(['name' => 'Admin', 'email' => 'admin@example.com', 'role' => UserRole::Admin->value]);
        User::factory()->create(['name' => 'Recruiter', 'email' => 'recruiter@example.com', 'role' => UserRole::Recruiter->value]);
        User::factory()->create(['name' => 'Mentor', 'email' => 'mentor@example.com', 'role' => UserRole::Mentor->value]);
    }
}
