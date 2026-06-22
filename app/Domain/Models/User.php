<?php

namespace App\Domain\Models;

use App\Domain\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function getRole(): UserRole
    {
        return UserRole::from($this->role);
    }

    public function hasRole(UserRole $role): bool
    {
        return $this->getRole() === $role;
    }
}
