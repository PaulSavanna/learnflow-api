<?php

namespace App\Domain\Exceptions;

use App\Domain\Enums\CandidateStatus;
use InvalidArgumentException;

class InvalidStatusTransition extends InvalidArgumentException
{
    public static function between(CandidateStatus $from, CandidateStatus $to): static
    {
        return new static("Cannot transition candidate from [{$from->value}] to [{$to->value}].");
    }
}
