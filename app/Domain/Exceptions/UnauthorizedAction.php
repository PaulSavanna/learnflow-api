<?php

namespace App\Domain\Exceptions;

use InvalidArgumentException;

class UnauthorizedAction extends InvalidArgumentException
{
    public static function forRole(string $role, string $action): static
    {
        return new static("Role [{$role}] is not authorized to perform [{$action}].");
    }
}
