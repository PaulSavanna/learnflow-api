<?php

namespace App\Http\Requests;

use App\Domain\Enums\CandidateStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCandidateStatusRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:' . implode(',', array_column(CandidateStatus::cases(), 'value')),
        ];
    }
}
